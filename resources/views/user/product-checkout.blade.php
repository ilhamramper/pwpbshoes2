@extends('layoutsuser.template')

@section('user')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Checkout</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('cart') }}">Cart<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('product.checkout') }}">Checkout</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Checkout Area =================-->
    <section class="checkout_area section_gap">
        <div class="container">
            <div class="billing_details">
                <div class="row">
                    <form class="row contact_form" action="{{ route('place.order') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="col-lg-8">
                            <style>
                                .nice-select {
                                    font-size: 15px !important;
                                }

                                .nice-select .list {
                                    max-height: 200px;
                                    overflow-y: auto;
                                }

                                .nice-select .option {
                                    font-size: 14px !important;
                                }

                                .alert {
                                    margin-top: 8px;
                                    margin-bottom: -10px;
                                    height: 38px;
                                    display: flex;
                                    align-items: center;
                                }

                                .alert .close {
                                    top: 50%;
                                    transform: translateY(-50%);
                                    position: absolute;
                                }
                            </style>
                            <h3>Billing Details</h3>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="number" name="phone" placeholder="No. HP" value="{{ old('phone') }}"
                                    style="font-size: 15px" required>
                                @error('phone')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <select class="country_select" id="province_select" name="province_select"
                                    data-width="100%">
                                    <option value="0">Pilih Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <select class="country_select" id="regency_select" name="regency_select" data-width="100%">
                                    <option value="0">Pilih Kab/Kota</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <select class="country_select" id="district_select" name="district_select"
                                    data-width="100%">
                                    <option value="0">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <select class="country_select form-control" id="village_select" name="village_select"
                                    data-width="100%">
                                    <option value="0">Pilih Kelurahan</option>
                                </select>
                            </div>
                            <div class="col-md-12 form-group p_star">
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}" id="address" name="address" placeholder="Detail Alamat"
                                    style="font-size: 15px" required>
                                @error('address')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ $message }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group">
                                <h3>Shipping Details</h3>
                                <select class="country_select mb-4" name="shippingOption" id="shippingOption"
                                    onchange="updateShippingCost()">
                                    <option value="0" {{ old('shippingOption') == '0' ? 'selected' : '' }}>Pilih
                                        Pengiriman</option>
                                    <option value="5.00" {{ old('shippingOption') == '5.00' ? 'selected' : '' }}>Regular
                                        Shipping: $5.00</option>
                                    <option value="20.00" {{ old('shippingOption') == '20.00' ? 'selected' : '' }}>Fast
                                        Shipping: $20.00</option>
                                </select>
                            </div>
                        </div>
                        <style>
                            .order_table,
                            .order_totals,
                            .payment_method {
                                width: 100%;
                                border-collapse: collapse;
                                margin-bottom: 10px;
                            }

                            .order_table th,
                            .order_table td,
                            .order_totals th,
                            .order_totals td,
                            .payment_method th,
                            .payment_method td {
                                border: none;
                            }

                            .order_table td,
                            .order_totals th,
                            .order_totals td {
                                padding: 5px 0px;
                            }
                        </style>
                        <div class="col-lg-4">
                            <div class="order_box">
                                <h2>Your Order</h2>
                                <div class="order_details">
                                    <table class="order_table">
                                        <tr>
                                            <th style="width: 45%; text-align: left;">PRODUCT</th>
                                            <th style="width: 25%; text-align: center;">QTY</th>
                                            <th style="width: 30%; text-align: right;">TOTAL</th>
                                        </tr>
                                        @foreach ($checkoutItems as $checkoutItem)
                                            <tr>
                                                <td style="width: 45%; text-align: left;">{{ $checkoutItem->item->name }}
                                                </td>
                                                <td style="width: 25%; text-align: center;">x{{ $checkoutItem->qty }}</td>
                                                <td style="width: 30%; text-align: right;">
                                                    ${{ number_format($checkoutItem->total, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="order_totals">
                                    <table class="order_totals">
                                        <tr>
                                            <th style="width: 50%; text-align: left;">SUBTOTAL</th>
                                            <th></th>
                                            <td style="width: 50%; text-align: right;">${{ number_format($subtotal, 2) }}
                                            </td>
                                        </tr>
                                        <tr id="shippingRow">
                                            <th style="width: 50%; text-align: left;">SHIPPING</th>
                                            <th></th>
                                            <td style="width: 50%; text-align: right;" id="shippingCost">+ $0.00
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width: 50%; text-align: left;">TOTAL</th>
                                            <th></th>
                                            <td style="width: 50%; text-align: right;" id="totalAmount">
                                                ${{ number_format($subtotal, 2) }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="payment_method">
                                    <table class="payment_method">
                                        <tr>
                                            <th>PAYMENT METHOD</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="radion_btn">
                                                    <input type="radio" id="f-option6" name="selector">
                                                    <label for="f-option6">Cash On Delivery (COD) </label>
                                                    <div class="check"></div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <input type="hidden" id="province_input" name="province_input" value="">
                                <input type="hidden" id="regency_input" name="regency_input" value="">
                                <input type="hidden" id="district_input" name="district_input" value="">
                                <input type="hidden" id="village_input" name="village_input" value="">
                                <input type="hidden" id="shipping_input" name="shipping_id" value="">
                                <input type="hidden" id="payment_input" name="payment" value="COD">

                                <button type="submit" class="primary-btn" style="width: 100%">Proceed Checkout</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--================End Checkout Area =================-->
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
        function updateShippingCost() {
            var shippingOption = document.getElementById("shippingOption");
            var shippingCostRow = document.getElementById("shippingRow");
            var shippingCostElement = document.getElementById("shippingCost");
            var totalLabelElement = document.getElementById("totalLabel");
            var totalAmountElement = document.getElementById("totalAmount");

            var shippingCostValue = parseFloat(shippingOption.value) || 0;

            shippingCostRow.style.display = "table-row";
            shippingCostElement.textContent = "+ $" + shippingCostValue.toFixed(2);

            var subtotal = parseFloat("{{ $subtotal }}") || 0;
            var total = subtotal + shippingCostValue;

            totalAmountElement.textContent = "$" + formatCurrency(total);
        }

        function formatCurrency(amount) {
            return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }

        function populateDropdown(selectId, data, placeholderText) {
            const select = $(`#${selectId}`);
            select.empty();
            select.append($('<option>').val('0').text(placeholderText));

            $.each(data, function(index, item) {
                select.append($('<option>').val(item.id).text(item.name));
            });

            select.niceSelect('update');
        }

        function populateProvinces() {
            $.getJSON('/get-provinces', function(data) {
                    populateDropdown("province_select", data, "Pilih Provinsi");
                })
                .fail(function(error) {
                    console.error('Error:', error);
                });
        }

        function fetchDropdownData(url, targetSelect, placeholderText) {
            $.getJSON(url, function(data) {
                    populateDropdown(targetSelect, data, placeholderText);
                })
                .fail(function(error) {
                    console.error('Error:', error);
                });
        }

        function updateShippingId() {
            var shippingOption = document.getElementById("shippingOption");
            var shippingInput = document.getElementById("shipping_input");

            var shippingIdValue = "0";

            if (shippingOption.value === "5.00") {
                shippingIdValue = "1";
            } else if (shippingOption.value === "20.00") {
                shippingIdValue = "2";
            }

            shippingInput.value = shippingIdValue;
        }

        function updatePaymentMethod() {
            var paymentInput = document.getElementById("payment_input");
            var cashOnDelivery = document.getElementById("f-option6");

            paymentInput.value = cashOnDelivery.checked ? "COD" : "";
        }

        $(document).ready(function() {
            populateProvinces();

            $('select').niceSelect();

            $("#province_select").change(function() {
                const provinceId = $(this).val();
                const regencySelect = $("#regency_select");

                if (provinceId === '0') {
                    resetDropdown("regency_select", "Pilih Kab/Kota");
                    resetDropdown("district_select", "Pilih Kecamatan");
                    resetDropdown("village_select", "Pilih Kelurahan");
                    $("#province_input").val('0');
                    $("#regency_input").val('0');
                    $("#district_input").val('0');
                    $("#village_input").val('0');
                } else {
                    fetchDropdownData(`/get-regencies/${provinceId}`, "regency_select", 'Pilih Kab/Kota');
                }
            });

            $("#regency_select").change(function() {
                const regencyId = $(this).val();
                const districtSelect = $("#district_select");

                if (regencyId === '0') {
                    resetDropdown("district_select", "Pilih Kecamatan");
                    resetDropdown("village_select", "Pilih Kelurahan");
                    $("#regency_input").val('0');
                    $("#district_input").val('0');
                    $("#village_input").val('0');
                } else {
                    fetchDropdownData(`/get-districts/${regencyId}`, "district_select", 'Pilih Kecamatan');
                }
            });

            $("#district_select").change(function() {
                const districtId = $(this).val();
                const villageSelect = $("#village_select");

                if (districtId === '0') {
                    resetDropdown("village_select", "Pilih Kelurahan");
                    $("#district_input").val('0');
                    $("#village_input").val('0');
                } else {
                    fetchDropdownData(`/get-villages/${districtId}`, "village_select", 'Pilih Kelurahan');
                }
            });

            function resetDropdown(selectId, placeholderText) {
                const select = $(`#${selectId}`);
                select.empty();
                select.append($('<option>').val('0').text(placeholderText));
                select.val('0');
                select.niceSelect('update');
            }

            function updateInputValues(selectId, inputId) {
                $("#" + selectId).change(function() {
                    var selectedOption = $("#" + selectId + " option:selected");
                    var selectedId = selectedOption.val();
                    $("#" + inputId).val(selectedId);
                });
            }

            updateInputValues("province_select", "province_input");
            updateInputValues("regency_select", "regency_input");
            updateInputValues("district_select", "district_input");
            updateInputValues("village_select", "village_input");

            $("#shippingOption").change(function() {
                updateShippingId();
                updateShippingCost();
            });

            $("#f-option6").change(function() {
                updatePaymentMethod();
            });
        });
    </script>
@endsection
