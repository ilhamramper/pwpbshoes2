@extends('layoutsadmin.template')

@section('admin')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Detail Item</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Item</h6>
                <a href="{{ route('dataItem') }}" class="btn btn-primary">x</a>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row order_d_inner">
                        <div class="col-lg-12">
                            <div class="details_item">
                                <h4>Item Info</h4>
                                <table class="table">
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Image"
                                                style="max-width: 500px;" class="show-modal"
                                                data-name="{{ $name }}">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 15%">Name</td>
                                        <td style="width: 5%">:</td>
                                        <th>{{ $name }}</th>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>:</td>
                                        <th>{{ $description }}</th>
                                    </tr>
                                    <tr>
                                        <td>Price</td>
                                        <td>:</td>
                                        <th>${{ number_format($price, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <td>Discount Price</td>
                                        <td>:</td>
                                        <th>
                                            @if ($discount === null)
                                                ---
                                            @else
                                                ${{ number_format($price * (1 - $discount / 100), 2) }}
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>Discount</td>
                                        <td>:</td>
                                        <th>
                                            @if ($discount === null)
                                                ---
                                            @else
                                                {{ $discount }}%
                                            @endif
                                        </th>
                                    </tr>
                                </table>

                                <div class="d-flex align-items-center mb-3">
                                    <a href="{{ route('editItem', $id) }}" class="btn btn-warning">Edit Item</a>

                                    <form action="{{ route('destroyItem', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger ml-2"
                                            onclick="return confirm('Are you sure you want to delete this item?')">Delete Item</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="order_details_table">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <h4>Stock {{ $name }}</h4>
                            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#addStockModal">+ Add
                                Stock</button>
                        </div>
                        <div class="table-responsive">
                            @if ($stocks->count() > 0)
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Size</th>
                                            <th style="width: 30%">Stock</th>
                                            <th style="width: 30%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stocks as $stock)
                                            <tr>
                                                <th>
                                                    <p>{{ $stock->size }}</p>
                                                </th>
                                                <th>
                                                    <p>{{ $stock->stock }}</p>
                                                </th>
                                                <th>
                                                    <a href="#" class="btn btn-primary edit-stock-btn"
                                                        data-toggle="modal" data-target="#editStockModal"
                                                        data-id="{{ $stock->id }}" data-item-id="{{ $stock->item_id }}"
                                                        data-size="{{ $stock->size }}" data-stock="{{ $stock->stock }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>

                                                    <form action="{{ route('deleteStock', $stock->id) }}" method="post"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this stock entry?')"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 30%">Size</th>
                                            <th style="width: 30%">Stock</th>
                                            <th style="width: 30%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th colspan="3" class="text-center">
                                                <h5><strong>Not Set</strong></h5>
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStockModalLabel">Add Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('addStock') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="size">Size</label>
                            <input type="number" class="form-control" id="size" name="size" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <input type="hidden" name="item_id" value="{{ $id }}">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Stock Modal -->
    <div class="modal fade" id="editStockModal" tabindex="-1" role="dialog" aria-labelledby="editStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStockModalLabel">Edit Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editStockForm" action="{{ route('updateStock') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editSize">Size</label>
                            <input type="number" class="form-control" id="editSize" name="editSize" required>
                        </div>
                        <div class="form-group">
                            <label for="editStock">Stock</label>
                            <input type="number" class="form-control" id="editStock" name="editStock" required>
                        </div>
                        <input type="hidden" id="editItemId" name="editItemId">
                        <input type="hidden" id="editStockId" name="editStockId">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
        $('#editStockModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var itemId = button.data('item-id');
            var size = button.data('size');
            var stock = button.data('stock');
            var stockId = button.data('id');

            var modal = $(this);

            modal.find('#editSize').val(size);
            modal.find('#editStock').val(stock);
            modal.find('#editItemId').val(itemId);
            modal.find('#editStockId').val(stockId);
        });
    </script>
@endsection
