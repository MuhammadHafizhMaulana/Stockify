<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Attribute Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        form.inline { display:inline; }
        .error { color: red; font-size: 0.9em; }
        .success { color: green; margin-bottom: 10px; }
    </style>
</head>
<body>

    <h1>Product Attribute Dashboard</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    {{-- Form Tambah Category --}}
    <h2>Tambah Product Attribute</h2>
    <form action="{{ route('productAttribute.store') }}" method="POST">
        @csrf
        <div>
            <label>Name</label><br>
            <input type="text" name="name">
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div>
            <label>Product</label><br>
            <select name="product_id">
                <option value="">-- Pilih Product --</option>
                @foreach($product as $pr)
                    <option value="{{ $pr->id }}"
                        {{ old('product_id') == $pr->id ? 'selected' : '' }}>
                        {{ $pr->name }}
                    </option>
                @endforeach
            </select>
            @error('product_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Value</label><br>
            <input type="text" name="value">
            @error('value') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit">Simpan</button>
    </form>

    {{-- Daftar Category --}}
    <h2 style="margin-top:40px;">Daftar Product Attribute</h2>

    @if($productAttributes->count())
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Value</th>
                    <th>Product</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach($productAttributes as $productAttribute)
                <tr>
                    <td>{{ $productAttribute->id }}</td>
                    <td>{{ $productAttribute->name }}</td>
                    <td>{{ $productAttribute->value }}</td>
                    <td>{{ $productAttribute->product->name }}</td>
                    <td>{{ $productAttribute->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $productAttribute->updated_at->format('Y-m-d H:i') }}</td>
                    <td>
                        {{-- Link ke halaman edit --}}
                        <a href="{{ route('productAttribute.edit', $productAttribute->id) }}">Edit</a>

                        {{-- Form delete --}}
                        <form action="{{ route('productAttribute.destroy', $productAttribute->id) }}"
                              method="POST" class="inline"
                              onsubmit="return confirm('Yakin hapus Product Attribute ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada data Product Attribute.</p>
    @endif

</body>
</html>
