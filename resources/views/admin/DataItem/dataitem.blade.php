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
                <a href="{{ route('createItem') }}" class="btn btn-primary">+ Add Item</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Stock</th>
                                <th>Price Display</th>
                                <th>Detail</th>
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
                                    <td>
                                        @if ($item->totalStock > 0)
                                            {{ $item->totalStock }}
                                        @else
                                            Not Set
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->discount === null)
                                            ${{ number_format($item->price, 2) }}
                                        @else
                                            ${{ number_format($item->price * (1 - $item->discount / 100), 2) }}
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <style>
                                            .btn:not(.active-btn) {
                                                width: auto;
                                            }

                                            .btn.active-btn {
                                                width: 70px;
                                            }
                                        </style>
                                        <button type="button" class="btn btn-warning ml-2 detail-item-btn"
                                            onclick="window.location.href='{{ route('detailItem', ['id' => $item->id]) }}'"
                                            onmouseover="showDetailText(this)" onmouseout="hideDetailText(this)">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <br><span class="detail-text" style="display: none">Detail<br>Item</span>
                                        </button>
                                    </td>
                                </tr>
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
    @if (Session::has('success'))
        <script>
            toastr.success("{{ Session::get('success') }}", "Success");
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            toastr.error("{{ Session::get('error') }}", "Error");
        </script>
    @endif

    <script>
        function showDetailText(element) {
            var detailText = element.querySelector('.detail-text');
            detailText.style.display = 'inline-block';
            element.classList.add('active-btn');
        }

        function hideDetailText(element) {
            var detailText = element.querySelector('.detail-text');
            detailText.style.display = 'none';
            element.classList.remove('active-btn');
        }
    </script>
@endsection
