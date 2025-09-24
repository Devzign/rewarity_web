<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(): View
    {
        $dealerId = Auth::id();

        $purchases = Purchase::with('product')
            ->where('dealer_id', $dealerId)
            ->orderByDesc('purchase_date')
            ->get();

        $products = Product::where('dealer_id', $dealerId)
            ->orderBy('product_name')
            ->get();

        return view('dealer.purchases.index', [
            'purchases' => $purchases,
            'products' => $products,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'seller_name' => ['nullable', 'string', 'max:255'],
            'purchase_price' => ['required', 'numeric'],
            'quantity' => ['required', 'integer', 'min:1'],
            'purchase_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        $dealerId = Auth::id();

        $product = Product::where('id', $data['product_id'])
            ->where('dealer_id', $dealerId)
            ->firstOrFail();

        $data['dealer_id'] = $dealerId;

        $purchase = Purchase::create($data);

        $product->increment('current_stock', $data['quantity']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'purchase_id' => $purchase->id,
            ]);
        }

        return back()->with('status', 'Purchase recorded successfully.');
    }
}
