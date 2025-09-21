<h1>Edit Stock Transaction</h1>

<form action="{{ route('stockTransaction.update', $stockTransaction->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Stock Transaction</label><br>
        <select name="product_id">
            <option value="">-- Pilih Product --</option>
            @foreach($product as $pr)
            <option value="{{ $pr->id }}" {{ old('product_id', $stockTransaction->product_id) == $pr->id ? 'selected' : '' }}>
                {{ $pr->name }}
            </option>
            @endforeach
        </select>
        @error('product_id')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label>Quantity</label><br>
        <input type="number" name="quantity" value="{{ $stockTransaction->quantity }}">
        @error('quantity') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div>
        <label>Type</label><br>
        <select name="type">
            <option value="">-- Pilih Type --</option>
            <option value="masuk" {{ old('type', $stockTransaction->type) == 'masuk'  ? 'selected' : '' }}>Masuk</option>
            <option value="keluar" {{ old('type', $stockTransaction->type) == 'keluar' ? 'selected' : '' }}>Keluar</option>
        </select>
        @error('type')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    {{-- Pilihan Status --}}
    <div>
        <label>Status</label><br>
        <select name="status">
            <option value="">-- Pilih Status --</option>
            <option value="pending" {{ old('status', $stockTransaction->status) == 'pending'    ? 'selected' : '' }}>Pending</option>
            <option value="diterima" {{ old('status', $stockTransaction->status) == 'diterima'   ? 'selected' : '' }}>Diterima</option>
            <option value="ditolak" {{ old('status', $stockTransaction->status) == 'ditolak'    ? 'selected' : '' }}>Ditolak</option>
            <option value="dikeluarkan" {{ old('status', $stockTransaction->status) == 'dikeluarkan'? 'selected' : '' }}>Dikeluarkan</option>
        </select>
        @error('status')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label>Notes</label><br>
        <input type="text" name="notes" value="{{ $stockTransaction->notes }}">
        @error('quantity') <div class="error">{{ $message }}</div> @enderror
    </div>

    <button type="submit">Update</button>
</form>

<a href="{{ route('category.index') }}">← Back to List</a>
