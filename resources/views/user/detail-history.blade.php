@extends('layoutsuser.template')

@section('user')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Confirmation</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('history') }}">History<span class="lnr lnr-arrow-right"></span></a>
                        <a href="javascript:void(0);" onclick="reloadCurrentRoute()">Detail History</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Order Details Area =================-->
    <section class="order_details section_gap">
        <div class="container">
            <div class="row order_d_inner">
                <div class="col-lg-6">
                    <div class="details_item">
                        <h4>Order Info</h4>
                        <table class="table">
                            <tr>
                                <td style="width: 20%">Order Number</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $order->id_order }}</th>
                            </tr>
                            <tr>
                                <td style="width: 20%">Order Time</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $order->created_at->format('H:i:s Y-m-d') }}</th>
                            </tr>
                            <tr>
                                <td style="width: 20%">Total</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">${{ number_format($total, 2) }}</th>
                            </tr>
                            <tr>
                                <td style="width: 20%">Payment Method</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $order->payment }}</th>
                            </tr>
                            <tr>
                                <td style="width: 20%">Phone</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $order->phone }}</th>
                            </tr>
                            <tr>
                                <td style="width: 20%">Status</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%; font-weight: 500!important;">
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
                                </th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="details_item">
                        <h4>Shipping Address</h4>
                        <table class="table">
                            <tr>
                                <td style="width: 9%">Province</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $provinceName }}</th>
                            </tr>
                            <tr>
                                <td style="width: 9%">Regency</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $regencyName }}</th>
                            </tr>
                            <tr>
                                <td style="width: 9%">District</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $districtName }}</th>
                            </tr>
                            <tr>
                                <td style="width: 9%">Village</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $villageName }}</th>
                            </tr>
                            <tr>
                                <td style="width: 9%">Address</td>
                                <td style="width: 5%">:</td>
                                <th style="width: 55%">{{ $order->address }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="order_details_table">
                <h2>Order Details</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderDetails as $item)
                                <tr>
                                    <td>
                                        <p>{{ $item['item_name'] }}</p>
                                    </td>
                                    <td>
                                        <h5>x {{ $item['qty'] }}</h5>
                                    </td>
                                    <td>
                                        <p>${{ number_format($item['total'], 2) }}</p>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <h4>Subtotal</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p>${{ number_format($subtotal, 2) }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Shipping</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p>{{ $shippingOption }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4>Total</h4>
                                </td>
                                <td>
                                    <h5></h5>
                                </td>
                                <td>
                                    <p>${{ number_format($total, 2) }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!--================End Order Details Area =================-->
@endsection

@section('scripts')
    <script>
        function reloadCurrentRoute() {
            var currentRoute = window.location.href;
            window.location.href = currentRoute;
        }
    </script>
@endsection
