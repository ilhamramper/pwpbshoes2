@extends('layoutsadmin.template')

@section('admin')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tabel Data Order</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Order</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>Order Number</th>
                                <th>Total</th>
                                <th>Order Time</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->id_order }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>{{ $order->created_at->format('H:i:s Y-m-d') }}</td>
                                    <td>
                                        @if ($order->status == 1)
                                            Diproses
                                        @elseif($order->status == 2)
                                            Dikirim
                                        @elseif($order->status == 3)
                                            Diterima
                                        @elseif($order->status == 4)
                                            Gagal
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
                                        <button type="button" class="btn btn-primary position-relative edit-status-btn"
                                            data-toggle="modal" data-target="#editOrderStatusModal{{ $order->id_order }}"
                                            onclick="editOrderStatus(event, {{ $order->id_order }}, '{{ $order->status }}')"
                                            onmouseover="showEditText(this)" onmouseout="hideEditText(this)">
                                            <i class="fas fa-user-edit"></i>
                                            <br><span class="edit-text" style="display: none">Edit<br>Status</span>
                                        </button>
                                        <button type="button" class="btn btn-warning ml-2 detail-order-btn"
                                            onclick="window.location.href='{{ route('detailOrder', ['id' => $order->id_order]) }}'"
                                            onmouseover="showDetailText(this)" onmouseout="hideDetailText(this)">
                                            <i class="fas fa-exclamation-circle"></i>
                                            <br><span class="detail-text" style="display: none">Detail<br>Order</span>
                                        </button>
                                    </td>

                                    <!-- Modal for editing order status -->
                                    <div class="modal fade" id="editOrderStatusModal{{ $order->id_order }}" tabindex="-1"
                                        role="dialog" aria-labelledby="editOrderStatusModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editOrderStatusModalLabel">Edit Order Status
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="editOrderStatusForm{{ $order->id_order }}"
                                                        action="{{ route('updateOrderStatus', ['id' => $order->id_order]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-group">
                                                            <label for="status">Status:</label>
                                                            <select class="form-control" name="status"
                                                                id="status{{ $order->id_order }}"
                                                                onchange="updateHiddenInputValue('{{ $order->id_order }}', this.value)">
                                                                <option value="1"
                                                                    {{ $order->status == 1 ? 'selected' : '' }}>Diproses
                                                                </option>
                                                                <option value="2"
                                                                    {{ $order->status == 2 ? 'selected' : '' }}>Dikirim
                                                                </option>
                                                                <option value="3"
                                                                    {{ $order->status == 3 ? 'selected' : '' }}>Diterima
                                                                </option>
                                                                <option value="4"
                                                                    {{ $order->status == 4 ? 'selected' : '' }}>Gagal
                                                                </option>
                                                            </select>
                                                            <input type="hidden" name="real_status"
                                                                id="real_status{{ $order->id_order }}"
                                                                value="{{ $order->status }}">
                                                            <input type="hidden" name="hidden_status"
                                                                id="hidden_status{{ $order->id_order }}"
                                                                value="{{ $order->status }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="saveChangesButton{{ $order->id_order }}" disabled>
                                                            Save changes
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        function showEditText(element) {
            var editText = element.querySelector('.edit-text');
            editText.style.display = 'inline-block';
            element.classList.add('active-btn');
        }

        function hideEditText(element) {
            var editText = element.querySelector('.edit-text');
            editText.style.display = 'none';
            element.classList.remove('active-btn');
        }

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

        function editOrderStatus(event, orderId, currentStatus) {
            event.preventDefault();

            $('#status' + orderId).val(currentStatus);
            $('#editOrderStatusModal' + orderId).modal('show');
        }

        function updateOrderStatus(orderId) {
            $('#editOrderStatusForm' + orderId).submit();
        }

        function updateHiddenInputValue(orderId, selectedValue) {
            var hiddenStatusInput = $('#hidden_status' + orderId);
            hiddenStatusInput.val(selectedValue);

            var realStatus = $('#real_status' + orderId).val();
            var saveChangesButton = $('#saveChangesButton' + orderId);

            if (realStatus !== hiddenStatusInput.val()) {
                saveChangesButton.prop('disabled', false);
            } else {
                saveChangesButton.prop('disabled', true);
            }
        }
    </script>
@endsection
