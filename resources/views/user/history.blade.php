@extends('layoutsuser.template')

@section('user')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>History</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('history') }}">History</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <style>
                    .table th,
                    .table td {
                        text-align: center;
                        font-weight: bold;
                    }

                    .product-col {
                        width: 19%;
                    }

                    .name-col {
                        width: 19%;
                    }

                    .price-col {
                        width: 19%;
                    }

                    .qty-col {
                        width: 19%;
                    }

                    .total-col {
                        width: 19%;
                    }

                    .action-col {
                        width: 5%;
                    }
                </style>
                <div class="table-responsive">
                    @if (Auth::check())
                        @if ($history !== null && count($history) > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-col">Order Number</th>
                                        <th class="name-col">Total</th>
                                        <th class="price-col">Payment</th>
                                        <th class="qty-col">Status</th>
                                        <th class="total-col">Order Time</th>
                                        <th class="action-col">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($history as $order)
                                        <tr>
                                            <td>{{ $order->id_order }}</td>
                                            <td>${{ number_format($order->total_amount, 2) }}</td>
                                            <td>{{ $order->payment }}</td>
                                            <td style="font-weight: 500!important;">
                                                @if ($order->status == 1)
                                                    <span
                                                        style="background-color: yellow; color: black; padding: 5px 10px; border-radius: 10px;">Diproses</span>
                                                @elseif ($order->status == 2)
                                                    <span
                                                        style="background-color: orange;color: white; padding: 5px 10px; border-radius: 10px;">Dikirim</span>
                                                @elseif ($order->status == 3)
                                                    <span
                                                        style="background-color: green; color: white; padding: 5px 10px; border-radius: 10px;">Diterima</span>
                                                @elseif ($order->status == 4)
                                                    <span
                                                        style="background-color: red; color: white; padding: 5px 10px; border-radius: 10px;">Gagal</span>
                                                @else
                                                    <span>Unknown Status</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($order->created_at)
                                                    {{ $order->created_at->format('H:i:s Y-m-d') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('detailHistory', ['id' => $order->id_order]) }}"
                                                    class="btn" style="background-color: transparent; border: none;">
                                                    <i class="ti-eye" style="color: #ff6c00; font-size: 20px;"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-col">Order Number</th>
                                        <th class="name-col">Total</th>
                                        <th class="price-col">Payment</th>
                                        <th class="qty-col">Status</th>
                                        <th class="total-col">Order Time</th>
                                        <th class="action-col">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h3>Anda belum pernah melakukan pembelian.</h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-col">Order Number</th>
                                    <th class="name-col">Total</th>
                                    <th class="price-col">Payment</th>
                                    <th class="qty-col">Status</th>
                                    <th class="total-col">Order Time</th>
                                    <th class="action-col">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <h3>Anda belum login, tidak ada data yang tersimpan.</h3>
                                        <a href="{{ route('login') }}" class="btn btn-warning"><strong>Login</strong></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
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
@endsection
