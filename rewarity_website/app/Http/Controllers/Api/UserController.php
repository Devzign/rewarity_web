<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'userType' => ['required', 'string', 'max:255'],
            'mobileNumbers' => ['required', 'array', 'min:1'],
            'mobileNumbers.*.number' => ['required', 'string', 'max:20'],
            'mobileNumbers.*.isPrimary' => ['required', 'boolean'],
            'address' => ['required', 'array'],
            'address.address1' => ['required', 'string', 'max:255'],
            'address.address2' => ['nullable', 'string', 'max:255'],
            'address.city' => ['nullable', 'string', 'max:255'],
            'address.state' => ['nullable', 'string', 'max:255'],
            'address.pincode' => ['nullable', 'string', 'max:20'],
            'address.country' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $primaryMobileCount = collect($validated['mobileNumbers'])
            ->filter(fn (array $mobile): bool => (bool) ($mobile['isPrimary'] ?? false))
            ->count();

        if ($primaryMobileCount === 0) {
            throw ValidationException::withMessages([
                'mobileNumbers' => ['At least one primary mobile number is required.'],
            ]);
        }

        if ($primaryMobileCount > 1) {
            throw ValidationException::withMessages([
                'mobileNumbers' => ['Only one mobile number can be marked as primary.'],
            ]);
        }

        $user = DB::transaction(function () use ($validated): User {
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->user_type = $validated['userType'];
            $user->status = 'Active';
            $user->user_uid = $this->generateUniqueUserId();
            $user->employee_id = $this->generateNextEmployeeId();
            $user->password = $validated['password'];
            $user->save();

            $user->address()->create([
                'address1' => $validated['address']['address1'],
                'address2' => $validated['address']['address2'] ?? null,
                'city' => $validated['address']['city'] ?? null,
                'state' => $validated['address']['state'] ?? null,
                'pincode' => $validated['address']['pincode'] ?? null,
                'country' => $validated['address']['country'] ?? null,
            ]);

            $mobilePayload = collect($validated['mobileNumbers'])
                ->map(fn (array $mobile): array => [
                    'number' => $mobile['number'],
                    'is_primary' => (bool) $mobile['isPrimary'],
                ])->all();

            $user->mobileNumbers()->createMany($mobilePayload);

            return $user->fresh();
        });

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'data' => [
                'userId' => $user->user_uid,
                'employeeId' => $user->employee_id,
                'name' => $user->name,
                'email' => $user->email,
                'userType' => $user->user_type,
                'createdDate' => optional($user->created_at)->toISOString(),
                'status' => $user->status,
            ],
        ], 201);
    }

    public function index(): JsonResponse
    {
        $users = User::orderByDesc('created_at')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Users fetched successfully.',
            'data' => $users->map(fn (User $user): array => [
                'userId' => $user->user_uid,
                'employeeId' => $user->employee_id,
                'name' => $user->name,
                'email' => $user->email,
                'userType' => $user->user_type,
                'createdDate' => optional($user->created_at)->toISOString(),
                'status' => $user->status,
            ])->all(),
            'totalUsers' => $users->count(),
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identifier = $credentials['identifier'];

        $user = User::query()
            ->where(fn ($query) => $query
                ->where('user_uid', $identifier)
                ->orWhere('employee_id', $identifier)
                ->orWhere('email', $identifier)
            )
            ->orWhereHas('mobileNumbers', fn ($query) => $query->where('number', $identifier))
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
            ], 401);
        }

        $token = $this->generateJwtToken($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful.',
            'data' => [
                'userId' => $user->user_uid,
                'employeeId' => $user->employee_id,
                'name' => $user->name,
                'email' => $user->email,
                'userType' => $user->user_type,
                'token' => $token,
            ],
        ]);
    }

    private function generateUniqueUserId(): string
    {
        do {
            $userId = Str::upper(Str::random(16));
        } while (User::where('user_uid', $userId)->exists());

        return $userId;
    }

    private function generateNextEmployeeId(): string
    {
        $maxIndex = DB::table('users')
            ->whereNotNull('employee_id')
            ->selectRaw('MAX(CAST(SUBSTRING(employee_id, 4) AS UNSIGNED)) as max_index')
            ->lockForUpdate()
            ->value('max_index');

        $next = ($maxIndex ?? 0) + 1;

        return 'EMP'.str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    private function generateJwtToken(User $user): string
    {
        $issuedAt = now();
        $expiresAt = $issuedAt->copy()->addHours(12);

        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT',
        ];

        $payload = [
            'iss' => config('app.url', config('app.name', 'Laravel')),
            'sub' => $user->user_uid,
            'iat' => $issuedAt->timestamp,
            'exp' => $expiresAt->timestamp,
            'user' => [
                'id' => $user->id,
                'userId' => $user->user_uid,
                'employeeId' => $user->employee_id,
                'email' => $user->email,
                'userType' => $user->user_type,
            ],
        ];

        $segments = [
            $this->base64UrlEncode(json_encode($header, JSON_UNESCAPED_SLASHES)),
            $this->base64UrlEncode(json_encode($payload, JSON_UNESCAPED_SLASHES)),
        ];

        $secret = $this->getJwtSecret();
        $signature = hash_hmac('sha256', implode('.', $segments), $secret, true);

        $segments[] = $this->base64UrlEncode($signature);

        return implode('.', $segments);
    }

    private function getJwtSecret(): string
    {
        $key = config('app.key');

        if (is_string($key) && Str::startsWith($key, 'base64:')) {
            return base64_decode(substr($key, 7)) ?: '';
        }

        return $key ?? '';
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
