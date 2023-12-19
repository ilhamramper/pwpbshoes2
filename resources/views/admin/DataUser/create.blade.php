@extends('layoutsadmin.template')

@section('admin')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label class="font-weight-bold">id</label>
                <input type="text" class="form-control @error('id') is-invalid @enderror" name="id"
                    value="{{ old('id') }}" placeholder="Masukkan id">

                <!-- error message untuk id -->
                @error('id')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="font-weight-bold">Nama User</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
                    value="{{ old('nama') }}" placeholder="Masukkan Nama Lengkap">

                <!-- error message untuk keterangan aduan -->
                @error('nama')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="font-weight-bold">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" placeholder="Masukkan Email">

                <!-- error message untuk nama penangan -->
                @error('email')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>



            <div class="form-group">
                <label class="font-weight-bold">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                    value="{{ old('password') }}" placeholder="Buat password">

                <!-- error message untuk emai; -->
                @error('password')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
            <button type="reset" class="btn btn-md btn-warning">RESET</button>

        </form>

    </div>
    <!-- /.container-fluid -->
@endsection
