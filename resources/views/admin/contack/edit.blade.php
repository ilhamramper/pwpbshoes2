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
        <form action="{{ route('contack.update', $contacks->id) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')


            <div class="form-group">
                <label class="font-weight-bold">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email', $contacks->email) }}" placeholder="Update email">

                <!-- error message untuk email -->
                @error('email')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="font-weight-bold">Nomor</label>
                <textarea class="form-control @error('nomor') is-invalid @enderror" name="nomor" rows="5"
                    placeholder="Update nomor">{{ old('nomor', $contacks->nomor) }}</textarea>

                <!-- error message untuk nomor telepont -->
                @error('nomor')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label class="font-weight-bold">Lokasi</label>
                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi"
                    value="{{ old('lokasi', $contacks->lokasi) }}" placeholder="Update lokasi">

                <!-- error message untuk jenis kelamin -->
                @error('lokasi')
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
