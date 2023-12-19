@extends('layoutsadmin.template')

@section('admin')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tabel Data Barang</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                <a href="{{ route('createItem') }}" class="btn btn-primary">+ Tambah Barang</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>Nama</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Harga Asli</th>
                                <th>Harga Diskon</th>
                                <th>Diskon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <style>
                            .show-modal:hover {
                                cursor: pointer;
                            }
                        </style>
                        <tbody class="text-center">
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Image"
                                            style="max-width: 100px;" class="show-modal" data-name="{{ $item->name }}">
                                    </td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>${{ $item->price }}</td>
                                    <td>
                                        @if ($item->discount === null)
                                            ---
                                        @else
                                            ${{ number_format($item->price * (1 - $item->discount / 100), 2) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->discount !== null)
                                            {{ $item->discount }}%
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('editItem', $item->id) }}" class="btn btn-warning">Edit</a>
                                        <form action="{{ route('destroyItem', $item->id) }}" method="POST" class="ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus item ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="imageModal" tabindex="-1" role="dialog"
                                    aria-labelledby="imageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="imageModalLabel">Gambar</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img id="modalImage" src="" alt="Image" style="max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(event) {
                if (event.target.tagName === 'IMG' && event.target.classList.contains('show-modal')) {
                    var imageUrl = event.target.src;
                    var imageName = event.target.getAttribute('data-name');

                    var modalImage = document.getElementById('modalImage');
                    modalImage.src = imageUrl;

                    var modalTitle = document.getElementById('imageModalLabel');
                    modalTitle.textContent = 'Gambar Sepatu ' + imageName;

                    $('#imageModal').modal('show');
                }
            });
        });
    </script>
@endsection
