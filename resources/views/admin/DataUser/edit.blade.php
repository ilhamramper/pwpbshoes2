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
        <form action="{{ route('user.update', $users->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="form-group">
                <label class="font-weight-bold">Id</label>
                <input type="text" class="form-control @error('id') is-invalid @enderror" name="id"
                    value="{{ old('id', $users->id) }}" placeholder="Update Id">

                <!-- error message untuk email -->
                @error('id')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="font-weight-bold">Nama</label>
                <textarea class="form-control @error('nama') is-invalid @enderror" name="nama" rows="5"
                    placeholder="Update nama">{{ old('nama', $users->name) }}</textarea>

                <!-- error message untuk nomor telepont -->
                @error('nama')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="font-weight-bold">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', $users->email) }}" placeholder="Update Email">

                <!-- error message untuk jenis kelamin -->
                @error('email')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="font-weight-bold">Password</label>
                <input type="text" class="form-control @error('password') is-invalid @enderror" name="password"
                    value="{{ old('password', $users->password) }}" placeholder="Update password">

                <!-- error message untuk tempat tinggal -->
                @error('password')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
            <button type="reset" class="btn btn-md btn-warning">RESET</button>


        </form>

    </div>
    <!-- /.container-fluid -->
@endsection
