<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Category</title>
</head>
<body>
    <div class="container">
        <h1>Tambah Category</h1>

        {{-- Form Tambah Category --}}
        <form action="{{ route('add_category.store') }}" method="POST">
            @csrf
            <div>
                <label>Name</label>
                <input type="text" name="name">
                @error('name') <small style="color:red;">{{ $message }}</small>@enderror
            </div>

            <div>
                <label>Description</label>
                <input type="text" name="description">
                @error('description') <small style="color:red;">{{ $message }}</small>@enderror
            </div>

            <button type="submit">Simpan</button>
        </form>

        <hr>

        {{-- Tabel Daftar Category --}}
        <h2>Daftar Category</h2>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td>{{ $category->updated_at }}</td>
                        <td>
                            {{-- Edit --}}
                            <a href="{{ route('category.edit', $category->id) }}">Edit</a>

                            {{-- Hapus --}}
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Belum ada data kategori</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
