@php($isEdit = isset($isEdit) && $isEdit)
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="product_name">Product name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="product_code">Product code</label>
            <input type="text" name="product_code" id="product_code" class="form-control" value="{{ old('product_code', $product->product_code) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="dealer_id">Dealer</label>
            <select name="dealer_id" id="dealer_id" class="form-control" required>
                <option value="">Select dealer</option>
                @foreach ($dealers as $dealer)
                    <option value="{{ $dealer->id }}" @selected((int) old('dealer_id', $product->dealer_id) === $dealer->id)>{{ $dealer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="purchase_price">Purchase price</label>
            <input type="number" step="0.01" min="0" name="purchase_price" id="purchase_price" class="form-control" value="{{ old('purchase_price', $product->purchase_price) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="selling_price">Selling price</label>
            <input type="number" step="0.01" min="0" name="selling_price" id="selling_price" class="form-control" value="{{ old('selling_price', $product->selling_price) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="start_date">Start date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', optional($product->start_date)->format('Y-m-d')) }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="current_stock">Current stock</label>
            <input type="number" min="0" name="current_stock" id="current_stock" class="form-control" value="{{ old('current_stock', $product->current_stock) }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="low_stock_alert">Low stock alert threshold</label>
            <input type="number" min="0" name="low_stock_alert" id="low_stock_alert" class="form-control" value="{{ old('low_stock_alert', $product->low_stock_alert) }}" required>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="1" @selected(old('status', $product->status ? '1' : '0') == '1')>Active</option>
                <option value="0" @selected(old('status', $product->status ? '1' : '0') == '0')>Inactive</option>
            </select>
        </div>
    </div>
</div>
