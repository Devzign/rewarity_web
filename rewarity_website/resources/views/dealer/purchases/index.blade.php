@extends('layouts.dealer')

@section('title', 'Purchases')

@section('content')
<div class="space-y-8">
    <section class="rounded-lg bg-white p-6 shadow">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Purchase History</h2>
            <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Back to Products</a>
        </div>
        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Product</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Seller</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Price</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Quantity</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Purchase Date</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($purchases as $purchase)
                        <tr>
                            <td class="px-4 py-3 text-gray-700">{{ $purchase->product->product_name ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $purchase->seller_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-gray-500">₹{{ number_format($purchase->purchase_price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $purchase->quantity }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ optional($purchase->purchase_date)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $purchase->notes ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">No purchases found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-lg bg-white p-6 shadow">
        <h3 class="text-lg font-semibold text-gray-800">Quick Purchase Entry</h3>
        <form class="mt-4 grid gap-4" action="{{ route('purchases.store') }}" method="POST">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product</label>
                    <select name="product_id" class="mt-1 w-full rounded border-gray-300" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }} ({{ $product->product_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Seller Name</label>
                    <input type="text" name="seller_name" class="mt-1 w-full rounded border-gray-300" />
                </div>
            </div>
            <div class="grid gap-4 sm:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Purchase Price</label>
                    <input type="number" step="0.01" name="purchase_price" class="mt-1 w-full rounded border-gray-300" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" min="1" class="mt-1 w-full rounded border-gray-300" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Purchase Date</label>
                    <input type="date" name="purchase_date" class="mt-1 w-full rounded border-gray-300" required />
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" rows="3" class="mt-1 w-full rounded border-gray-300"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Save Purchase</button>
            </div>
        </form>
    </section>
</div>
@endsection
