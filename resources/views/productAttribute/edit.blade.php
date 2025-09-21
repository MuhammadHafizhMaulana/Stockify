<h1>Edit Product Attribute</h1>

<form action="{{ route('productAttribute.update', $productAttribute->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name', $productAttribute->name) }}">
        @error('name') <small style="color:red;">{{ $message }}</small>@enderror
    </div>

    <div>
        <label>Value</label>
        <input type="text" name="value" value="{{ old('description', $productAttribute->value) }}">
        @error('value') <small style="color:red;">{{ $message }}</small>@enderror
    </div>

    <div>
            <label>Product</label><br>
            <select name="product_id">
                @foreach($products as $pro)
                    <option value="{{ $pro->id }}"
                        {{ old('product_id', $productAttribute->pro_id) == $pro->id ? 'selected' : '' }}>
                        {{ $pro->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

    <button type="submit">Update</button>
</form>

<a href="{{ route('productAttribute.index') }}">← Back to List</a>
