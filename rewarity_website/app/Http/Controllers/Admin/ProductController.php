<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $dealerId = $request->integer('dealer_id');

        /** @var LengthAwarePaginator $products */
        $products = Product::with('dealer')
            ->when($search, function (Builder $query) use ($search): void {
                $query->where(function (Builder $subQuery) use ($search): void {
                    $subQuery->where('product_name', 'like', "%{$search}%")
                        ->orWhere('product_code', 'like', "%{$search}%");
                });
            })
            ->when($dealerId, fn (Builder $query) => $query->where('dealer_id', $dealerId))
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $dealers = User::query()
            ->whereRaw('LOWER(user_type) = ?', ['dealer'])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.products.index', [
            'products' => $products,
            'dealers' => $dealers,
            'filters' => [
                'search' => $search,
                'dealer_id' => $dealerId,
            ],
            'pageHeading' => 'Products',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $dealers = User::query()
            ->whereRaw('LOWER(user_type) = ?', ['dealer'])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.products.create', [
            'product' => new Product(),
            'dealers' => $dealers,
            'pageHeading' => 'Add Product',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProduct($request);

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): View
    {
        $product->loadMissing([
            'dealer',
            'purchases' => fn ($query) => $query->orderByDesc('purchase_date'),
        ]);

        return view('admin.products.show', [
            'product' => $product,
            'pageHeading' => 'Product Details',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        $dealers = User::query()
            ->whereRaw('LOWER(user_type) = ?', ['dealer'])
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.products.edit', [
            'product' => $product,
            'dealers' => $dealers,
            'pageHeading' => 'Edit Product',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validateProduct($request, $product);

        $product->update($data);

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Product deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateProduct(Request $request, ?Product $product = null): array
    {
        $uniqueRule = Rule::unique('products', 'product_code');

        if ($product) {
            $uniqueRule = $uniqueRule->ignore($product->id);
        }

        $validated = $request->validate([
            'product_code' => ['required', 'string', 'max:255', $uniqueRule],
            'product_name' => ['required', 'string', 'max:255'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'current_stock' => ['nullable', 'integer', 'min:0'],
            'low_stock_alert' => ['required', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in([true, false, 0, 1, '0', '1'])],
            'dealer_id' => ['required', 'exists:users,id'],
        ]);

        $validated['status'] = filter_var($validated['status'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
        $validated['current_stock'] = $validated['current_stock'] ?? 0;

        $dealer = User::where('id', $validated['dealer_id'])
            ->whereRaw('LOWER(user_type) = ?', ['dealer'])
            ->exists();

        if (! $dealer) {
            throw ValidationException::withMessages([
                'dealer_id' => 'The selected dealer is invalid.',
            ]);
        }

        return $validated;
    }
}
