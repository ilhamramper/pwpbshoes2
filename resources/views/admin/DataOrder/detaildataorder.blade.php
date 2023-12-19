@extends('layoutsadmin.template')

@section('admin')
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Detail Data Order</h1>

        <!-- Form Input Data -->
        <style>

        </style>
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Data Order {{ $orderNumber }}</h6>
                <a href="{{ route('dataOrder') }}" class="btn btn-primary">x</a>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row order_d_inner">
                        <div class="col-lg-6">
                            <div class="details_item">
                                <h4>Order Info</h4>
                                <table class="table">
                                    <tr>
                                        <td style="width: 25%">Order Number</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $orderNumber }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%">Order Time</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $date }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%">Total</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">${{ number_format($total, 2) }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%">Payment Method</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $paymentMethod }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 25%">Phone</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $order->phone }}</th>
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
                                        <th style="width: 55%">{{ $province }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 9%">Regency</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $regency }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 9%">District</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $district }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 9%">Village</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $village }}</th>
                                    </tr>
                                    <tr>
                                        <td style="width: 9%">Address</td>
                                        <td style="width: 5%">:</td>
                                        <th style="width: 55%">{{ $address }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="order_details_table">
                        <h4>Order Details</h4>
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
                                                <p>x {{ $item['qty'] }}</p>
                                            </td>
                                            <td>
                                                <p>${{ number_format($item['total'], 2) }}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td>
                                            <p>Subtotal</p>
                                        </td>
                                        <td>
                                            <p></p>
                                        </td>
                                        <th>
                                            <p>${{ $subtotal }}</p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Shipping</p>
                                        </td>
                                        <td>
                                            <p></p>
                                        </td>
                                        <th>
                                            <p>{{ $shippingOption }}</p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>Total</p>
                                        </td>
                                        <td>
                                            <p></p>
                                        </td>
                                        <th>
                                            <p>${{ number_format($total, 2) }}</p>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
