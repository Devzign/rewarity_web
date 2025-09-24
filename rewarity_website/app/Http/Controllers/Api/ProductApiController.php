<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query()->with('purchases:id,product_id,quantity,purchase_date');

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

        $products = $query->orderBy('product_name')->get();

        return response()->json([
            'status' => 'success',
            'data' => $products->map(fn (Product $product): array => [
                'id' => $product->id,
                'productCode' => $product->product_code,
                'productName' => $product->product_name,
                'purchasePrice' => (float) $product->purchase_price,
                'sellingPrice' => (float) $product->selling_price,
                'currentStock' => $product->current_stock,
                'lowStockAlert' => $product->low_stock_alert,
                'startDate' => optional($product->start_date)->toDateString(),
                'status' => (bool) $product->status,
            ]),
        ]);
    }
}
