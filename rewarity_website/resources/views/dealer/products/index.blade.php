@extends('layouts.dealer')

@section('title', 'Products')

@section('content')
<div x-data="productDashboard({
        storeUrl: '{{ route('products.store') }}',
        updateUrl: '{{ route('products.update', '__ID__') }}',
        deleteUrl: '{{ route('products.destroy', '__ID__') }}',
        purchaseStoreUrl: '{{ route('purchases.store') }}'
    })" class="space-y-10">
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-sm text-gray-500">Total Products</p>
            <p class="mt-2 text-2xl font-semibold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-sm text-gray-500">In Stock</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $stats['in_stock'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-sm text-gray-500">Low Stock</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600">{{ $stats['low_stock'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-6 shadow">
            <p class="text-sm text-gray-500">Out of Stock</p>
            <p class="mt-2 text-2xl font-semibold text-rose-600">{{ $stats['out_of_stock'] }}</p>
        </div>
    </section>

    <section class="rounded-lg bg-white shadow">
        <div class="flex items-center justify-between border-b px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-800">Products</h2>
            <div class="space-x-3">
                <button @click="openProductModal()" class="inline-flex items-center rounded bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">+ Add Product</button>
                <button @click="openPurchaseModal()" class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Add Purchase</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Product</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Code</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Purchase Price</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Selling Price</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Stock</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3 text-gray-700">{{ $product->product_name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $product->product_code }}</td>
                            <td class="px-4 py-3 text-gray-500">₹{{ number_format($product->purchase_price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-500">₹{{ number_format($product->selling_price, 2) }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $product->current_stock }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $product->status ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $product->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right text-sm font-medium">
                                <button @click="editProduct({{ $product->toJson() }})" class="text-emerald-600 hover:text-emerald-800">Edit</button>
                                <button @click="confirmDelete({{ $product->id }})" class="ml-3 text-rose-600 hover:text-rose-800">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">No products found. Start by adding a new product.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <template x-if="flashMessage">
        <div class="fixed inset-x-0 top-4 mx-auto max-w-md rounded bg-emerald-500 px-4 py-3 text-sm text-white shadow" x-text="flashMessage" x-transition></div>
    </template>

    <!-- Product Modal -->
    <div x-show="showProductModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="w-full max-w-xl rounded-lg bg-white p-6 shadow" @click.away="closeProductModal()">
            <h3 class="text-lg font-semibold text-gray-800" x-text="productForm.id ? 'Edit Product' : 'Add Product'"></h3>
            <form class="mt-4 space-y-4" @submit.prevent="submitProduct()">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" x-model="productForm.product_name" class="mt-1 w-full rounded border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product Code</label>
                    <input type="text" x-model="productForm.product_code" class="mt-1 w-full rounded border-gray-300" required>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Purchase Price</label>
                        <input type="number" step="0.01" x-model="productForm.purchase_price" class="mt-1 w-full rounded border-gray-300" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Selling Price</label>
                        <input type="number" step="0.01" x-model="productForm.selling_price" class="mt-1 w-full rounded border-gray-300" required>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Current Stock</label>
                        <input type="number" x-model="productForm.current_stock" class="mt-1 w-full rounded border-gray-300" min="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Low Stock Alert</label>
                        <input type="number" x-model="productForm.low_stock_alert" class="mt-1 w-full rounded border-gray-300" min="0" required>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" x-model="productForm.start_date" class="mt-1 w-full rounded border-gray-300">
                    </div>
                    <div class="flex items-center space-x-2 pt-6">
                        <input type="checkbox" x-model="productForm.status" class="rounded border-gray-300">
                        <span class="text-sm text-gray-700">Active</span>
                    </div>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="closeProductModal()" class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="rounded bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Purchase Modal -->
    <div x-show="showPurchaseModal" x-cloak class="fixed inset-0 z-40 flex items-center justify-center bg-black/50">
        <div class="w-full max-w-xl rounded-lg bg-white p-6 shadow" @click.away="closePurchaseModal()">
            <h3 class="text-lg font-semibold text-gray-800">Add Purchase</h3>
            <form class="mt-4 space-y-4" @submit.prevent="submitPurchase()">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Product</label>
                    <select x-model="purchaseForm.product_id" class="mt-1 w-full rounded border-gray-300" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }} ({{ $product->product_code }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Seller Name</label>
                        <input type="text" x-model="purchaseForm.seller_name" class="mt-1 w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Purchase Price</label>
                        <input type="number" step="0.01" x-model="purchaseForm.purchase_price" class="mt-1 w-full rounded border-gray-300" required>
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" x-model="purchaseForm.quantity" class="mt-1 w-full rounded border-gray-300" min="1" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Purchase Date</label>
                        <input type="date" x-model="purchaseForm.purchase_date" class="mt-1 w-full rounded border-gray-300" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea x-model="purchaseForm.notes" class="mt-1 w-full rounded border-gray-300" rows="3"></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="closePurchaseModal()" class="rounded bg-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-300">Cancel</button>
                    <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Save Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function productDashboard(config) {
        return {
            showProductModal: false,
            showPurchaseModal: false,
            flashMessage: '',
            productForm: {
                id: null,
                product_name: '',
                product_code: '',
                purchase_price: '',
                selling_price: '',
                current_stock: '',
                low_stock_alert: 5,
                start_date: '',
                status: true,
            },
            purchaseForm: {
                product_id: '',
                seller_name: '',
                purchase_price: '',
                quantity: 1,
                purchase_date: '',
                notes: '',
            },
            openProductModal() {
                this.resetProductForm();
                this.showProductModal = true;
            },
            editProduct(product) {
                this.productForm = {
                    id: product.id,
                    product_name: product.product_name,
                    product_code: product.product_code,
                    purchase_price: product.purchase_price,
                    selling_price: product.selling_price,
                    current_stock: product.current_stock,
                    low_stock_alert: product.low_stock_alert,
                    start_date: product.start_date,
                    status: Boolean(product.status),
                };
                this.showProductModal = true;
            },
            closeProductModal() {
                this.showProductModal = false;
            },
            resetProductForm() {
                this.productForm = {
                    id: null,
                    product_name: '',
                    product_code: '',
                    purchase_price: '',
                    selling_price: '',
                    current_stock: '',
                    low_stock_alert: 5,
                    start_date: '',
                    status: true,
                };
            },
            submitProduct() {
                const payload = {
                    product_name: this.productForm.product_name,
                    product_code: this.productForm.product_code,
                    purchase_price: this.productForm.purchase_price,
                    selling_price: this.productForm.selling_price,
                    current_stock: this.productForm.current_stock === '' ? null : Number(this.productForm.current_stock),
                    low_stock_alert: this.productForm.low_stock_alert,
                    start_date: this.productForm.start_date || null,
                    status: this.productForm.status ? 1 : 0,
                };

                const url = this.productForm.id
                    ? config.updateUrl.replace('__ID__', this.productForm.id)
                    : config.storeUrl;
                const method = this.productForm.id ? 'PUT' : 'POST';

                fetch(url, {
                    method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(payload),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw response;
                        }
                        return response.json();
                    })
                    .then(() => {
                        this.flash('Product saved successfully.');
                        window.location.reload();
                    })
                    .catch(() => {
                        alert('Unable to save product. Please check the form and try again.');
                    });
            },
            confirmDelete(id) {
                if (!confirm('Are you sure you want to delete this product?')) {
                    return;
                }
                const url = config.deleteUrl.replace('__ID__', id);
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw response;
                        }
                        return response.json();
                    })
                    .then(() => {
                        this.flash('Product deleted successfully.');
                        window.location.reload();
                    })
                    .catch(() => {
                        alert('Unable to delete product.');
                    });
            },
            openPurchaseModal() {
                this.resetPurchaseForm();
                this.showPurchaseModal = true;
            },
            closePurchaseModal() {
                this.showPurchaseModal = false;
            },
            resetPurchaseForm() {
                this.purchaseForm = {
                    product_id: '',
                    seller_name: '',
                    purchase_price: '',
                    quantity: 1,
                    purchase_date: '',
                    notes: '',
                };
            },
            submitPurchase() {
                const payload = {
                    product_id: this.purchaseForm.product_id,
                    seller_name: this.purchaseForm.seller_name || null,
                    purchase_price: this.purchaseForm.purchase_price,
                    quantity: this.purchaseForm.quantity,
                    purchase_date: this.purchaseForm.purchase_date,
                    notes: this.purchaseForm.notes || null,
                };

                fetch(config.purchaseStoreUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify(payload),
                })
                    .then(response => {
                        if (!response.ok) {
                            throw response;
                        }
                        return response.json();
                    })
                    .then(() => {
                        this.flash('Purchase recorded and stock updated.');
                        window.location.reload();
                    })
                    .catch(() => {
                        alert('Unable to save purchase. Please check the form and try again.');
                    });
            },
            flash(message) {
                this.flashMessage = message;
                setTimeout(() => this.flashMessage = '', 3000);
            },
        };
    }
</script>
@endsection
