<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Purchase::query()->with('product:id,product_name,product_code');

        if ($request->filled('dealerId')) {
            $dealerId = (int) $request->input('dealerId');
            if ($dealerId > 0) {
                $query->where('dealer_id', $dealerId);
            }
        }

        if ($request->filled('dealerUid')) {
            $dealerId = User::where('user_uid', $request->string('dealerUid'))->value('id');
            if ($dealerId) {
                $query->where('dealer_id', $dealerId);
            }
        }

        if ($request->filled('productId')) {
            $query->where('product_id', (int) $request->input('productId'));
        }

        $purchases = $query->orderByDesc('purchase_date')->get();

        return response()->json([
            'status' => 'success',
            'data' => $purchases->map(fn (Purchase $purchase): array => [
                'id' => $purchase->id,
                'productId' => $purchase->product_id,
                'productName' => $purchase->product->product_name ?? null,
                'productCode' => $purchase->product->product_code ?? null,
                'dealerId' => $purchase->dealer_id,
                'sellerName' => $purchase->seller_name,
                'purchasePrice' => (float) $purchase->purchase_price,
                'quantity' => $purchase->quantity,
                'purchaseDate' => optional($purchase->purchase_date)->toDateString(),
                'notes' => $purchase->notes,
            ]),
        ]);
    }
}
