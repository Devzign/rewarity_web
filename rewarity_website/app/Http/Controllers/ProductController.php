<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $dealerId = Auth::id();

        $products = Product::where('dealer_id', $dealerId)
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total' => $products->count(),
            'in_stock' => $products->filter(fn (Product $product): bool => $product->current_stock > $product->low_stock_alert)->count(),
            'low_stock' => $products->filter(fn (Product $product): bool => $product->current_stock > 0 && $product->current_stock <= $product->low_stock_alert)->count(),
            'out_of_stock' => $products->filter(fn (Product $product): bool => $product->current_stock <= 0)->count(),
        ];

        return view('dealer.products.index', [
            'products' => $products,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate([
            'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code'],
            'product_name' => ['required', 'string', 'max:255'],
            'purchase_price' => ['required', 'numeric'],
            'selling_price' => ['required', 'numeric'],
            'current_stock' => ['nullable', 'integer', 'min:0'],
            'low_stock_alert' => ['required', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['dealer_id'] = Auth::id();
        $data['status'] = (bool) ($data['status'] ?? true);
        $data['current_stock'] = $data['current_stock'] ?? 0;

        Product::create($data);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('status', 'Product created successfully.');
    }

    public function update(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $this->authorizeProduct($product);

        $data = $request->validate([
            'product_code' => ['required', 'string', 'max:255', 'unique:products,product_code,' . $product->id],
            'product_name' => ['required', 'string', 'max:255'],
            'purchase_price' => ['required', 'numeric'],
            'selling_price' => ['required', 'numeric'],
            'current_stock' => ['nullable', 'integer', 'min:0'],
            'low_stock_alert' => ['required', 'integer', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['status'] = (bool) ($data['status'] ?? false);

        if (! array_key_exists('current_stock', $data) || $data['current_stock'] === null) {
            unset($data['current_stock']);
        }

        $product->update($data);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('status', 'Product updated successfully.');
    }

    public function destroy(Request $request, Product $product): JsonResponse|RedirectResponse
    {
        $this->authorizeProduct($product);
        $product->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('status', 'Product deleted successfully.');
    }

    private function authorizeProduct(Product $product): void
    {
        if ($product->dealer_id !== Auth::id()) {
            abort(403);
        }
    }
}
