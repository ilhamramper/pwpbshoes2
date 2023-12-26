@extends('layoutsadmin.template')

@section('admin')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edit Data Barang</h1>

        <!-- Form Input Data -->
        <style>

        </style>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit</h6>
                <a href="{{ route('detailItem', $item->id) }}" class="btn btn-primary">x</a>
            </div>
            <div class="card-body">
                <form onsubmit="return confirm('Are you sure want to update this item?');" enctype="multipart/form-data" method="POST"
                    action="{{ route('updateItem', $item->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-control-label">Nama Sepatu</label>
                        <input type="text" id="name" name="name" placeholder="Masukkan nama barang"
                            class="form-control" value="{{ old('name', $item->name) }}">
                    </div>
                    <div class="form-group">
                        <label for="image" class="form-control-label">Gambar Sepatu</label>
                        <div class="custom-file">
                            <label class="custom-file-label" for="image" id="fileLabel">Pilih file...</label>
                            <input type="file" class="custom-file-input" id="image" name="image"
                                onchange="updateLabel()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="form-control-label">Deskripsi Singkat Sepatu</label>
                        <input type="text" id="description" name="description" placeholder="Masukkan deskripsi barang"
                            class="form-control" value="{{ old('description', $item->description) }}">
                    </div>
                    <div class="form-group">
                        <label for="price" class="form-control-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" id="price" name="price" placeholder="Contoh: 100 / 100.50"
                                class="form-control" value="{{ old('price', $item->price) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="discount" class="form-control-label">Diskon</label>
                        <div class="input-group">
                            <input type="text" id="discount" name="discount"
                                placeholder="Contoh: 50 / 99, Minimal 1 dan Maksimal 99" class="form-control"
                                value="{{ $item->discount !== null ? old('discount', $item->discount) : '' }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-warning mx-1" href="{{ route('editItem', $item->id) }}">Reset</a>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('scripts')
    <script>
        function updateLabel() {
            var input = document.getElementById('image');
            var label = document.getElementById('fileLabel');
            label.innerHTML = input.files[0].name;
        }
    </script>
@endsection
