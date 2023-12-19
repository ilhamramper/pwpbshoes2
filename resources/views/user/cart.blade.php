@extends('layoutsuser.template')

@section('user')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('cart') }}">Cart</a>
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
                    }

                    .product-col {
                        width: 20%;
                    }

                    .name-col {
                        width: 30%;
                    }

                    .price-col {
                        width: 10%;
                    }

                    .qty-col {
                        width: 20%;
                    }

                    .total-col {
                        width: 10%;
                    }

                    .actions-col {
                        width: 10%;
                    }
                </style>
                <div class="table-responsive">
                    @if (Auth::check())
                        @if (count($cartItems) > 0)
                            <form action="{{ route('processCheckout') }}" method="POST" id="checkoutForm">
                                @csrf
                                @method('POST')
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="product-col">Product</th>
                                            <th class="name-col">Name</th>
                                            <th class="price-col">Price</th>
                                            <th class="qty-col">Quantity</th>
                                            <th class="total-col">Total</th>
                                            <th class="actions-col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <style>
                                            .input-text.qty::-webkit-inner-spin-button,
                                            .input-text.qty::-webkit-outer-spin-button {
                                                -webkit-appearance: none;
                                                margin: 0;
                                            }

                                            .input-text.qty {
                                                -moz-appearance: textfield;
                                            }
                                        </style>
                                        @foreach ($cartItems as $cartItem)
                                            <tr>
                                                <td class="product-col">
                                                    <div class="d-flex">
                                                        <img src="{{ asset('storage/' . $cartItem->item->image) }}"
                                                            alt="{{ $cartItem->item->name }}"
                                                            style="width: 150px; height: 150px; object-fit: fill;">
                                                    </div>
                                                </td>
                                                <td class="name-col">
                                                    <h5>{{ $cartItem->item->name }}</h5>
                                                </td>
                                                <td class="price-col">
                                                    <h5>
                                                        @if ($cartItem->item->discount === null)
                                                            ${{ number_format($cartItem->item->price, 2) }}
                                                        @else
                                                            ${{ number_format($cartItem->item->dprice, 2) }}
                                                        @endif
                                                    </h5>
                                                </td>
                                                <td class="qty-col">
                                                    <div class="product_count">
                                                        <input type="number" name="qty[{{ $cartItem->item->id }}]"
                                                            class="input-text qty"
                                                            data-price="@if ($cartItem->item->discount === null) {{ $cartItem->item->price }}@else{{ $cartItem->item->dprice }} @endif"
                                                            data-stock="{{ $cartItem->item->stock }}" value="1"
                                                            title="Quantity:">
                                                        <button class="increase items-count" type="button"><i
                                                                class="lnr lnr-chevron-up"></i></button>
                                                        <button class="reduced items-count" type="button"><i
                                                                class="lnr lnr-chevron-down"></i></button>
                                                    </div>
                                                </td>
                                                <td class="total-col">
                                                    <h5 class="item-total"
                                                        data-price="@if ($cartItem->item->discount === null) {{ $cartItem->item->price }}@else{{ $cartItem->item->dprice }} @endif">
                                                        @if ($cartItem->item->discount === null)
                                                            ${{ number_format($cartItem->item->price, 2) }}
                                                        @else
                                                            ${{ number_format($cartItem->item->dprice, 2) }}
                                                        @endif
                                                    </h5>
                                                </td>
                                                <td class="actions-col">
                                                    <button type="button" class="btn btn-danger ml-1 delete-item-btn"
                                                        data-item-id="{{ $cartItem->id }}">
                                                        <span class="ti-trash"></span>
                                                    </button>
                                                </td>
                                                <td class="hidden-qty-col">
                                                    <input type="hidden" name="hidden_qty[{{ $cartItem->item->id }}]"
                                                        class="hidden-qty" value="1">
                                                </td>
                                            </tr>
                                            <input type="hidden" name="hidden_stock[]"
                                                value="{{ $cartItem->item->stock }}" class="hidden-stock">
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="qty-col">
                                                <h5>Subtotal</h5>
                                            </td>
                                            <td class="total-col" id="subtotal">
                                                <h5 id="subtotal-value"></h5>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr class="out_button_area">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="actions-col">
                                                <div class="checkout_btn_inner d-flex align-items-center">
                                                    <a class="gray_btn" href="{{ route('shop') }}">Continue Shopping</a>
                                                    <button style="outline: none; border: none" type="submit"
                                                        class="primary-btn" onclick="submitForms()">Proceed to
                                                        checkout</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-col">Product</th>
                                        <th class="name-col">Name</th>
                                        <th class="price-col">Price</th>
                                        <th class="qty-col">Quantity</th>
                                        <th class="total-col">Total</th>
                                        <th class="actions-col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h3>Anda belum menambahkan apapun.</h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="product-col">Product</th>
                                    <th class="name-col">Name</th>
                                    <th class="price-col">Price</th>
                                    <th class="qty-col">Quantity</th>
                                    <th class="total-col">Total</th>
                                    <th class="actions-col">Actions</th>
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
                    <form action="{{ route('destroyCart', ['id' => 'replace_with_item_id']) }}" method="POST"
                        id="deleteForm" style="display: none;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="deleteItemId" id="deleteItemId" value="">
                    </form>
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

    <script>
        function submitForms() {
            document.getElementById('checkoutForm').submit();
        }

        $(document).ready(function() {
            $('.qty').on('input', function() {
                updateSubtotal();
                updateHiddenQty(this);
                updateTotal(this);
            });

            function updateTotal(input) {
                var itemId = $(input).attr('name').match(/\[(.*?)\]/)[1];
                var totalElement = $(input).closest('tr').find('.item-total');
                var price = parseFloat($(input).data('price'));
                var hiddenQtyInput = $('input[name="hidden_qty[' + itemId + ']"]');
                var quantity = parseInt(hiddenQtyInput.val());
                var total = price * quantity;
                totalElement.text('$' + formatCurrency(total));

                updateSubtotal();
            }

            function updateSubtotal() {
                var subtotal = 0;
                $('.item-total').each(function() {
                    var itemId = $(this).closest('tr').find('.qty').attr('name').match(/\[(.*?)\]/)[1];
                    var hiddenQtyInput = $('input[name="hidden_qty[' + itemId + ']"]');
                    var price = parseFloat($(this).data('price'));
                    var quantity = parseInt(hiddenQtyInput.val());
                    var total = price * quantity;
                    subtotal += total;
                });

                $('#subtotal-value').text('$' + formatCurrency(subtotal));
            }

            function formatCurrency(amount) {
                return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            function updateHiddenQty(input) {
                var itemId = $(input).attr('name').match(/\[(.*?)\]/)[1];
                var hiddenQtyInput = $('input[name="hidden_qty[' + itemId + ']"]');
                var stock = parseInt($(input).data('stock')) || 0;
                var inputValue = parseInt(input.value) || 0;

                hiddenQtyInput.val(Math.min(stock, inputValue));
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var quantityInputs = document.querySelectorAll('.qty');
            var totalElements = document.querySelectorAll('.item-total');
            var maxStocks = document.querySelectorAll('.hidden-stock');
            let deleteButtons = document.querySelectorAll('.delete-item-btn');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    let itemId = this.getAttribute('data-item-id');
                    document.getElementById('deleteItemId').value = itemId;
                    document.getElementById('deleteForm').action = '{{ url('destroyCart') }}/' +
                        itemId;
                    document.getElementById('deleteForm').submit();
                });
            });

            quantityInputs.forEach(function(quantityInput, index) {
                var totalElement = totalElements[index];
                var maxStock = parseInt(maxStocks[index].value) || 0;

                quantityInput.addEventListener('input', function() {
                    handleQuantityChange(quantityInput, maxStock);
                    updateTotal(quantityInput, totalElement);
                });

                quantityInput.nextElementSibling.addEventListener('click', function() {
                    increaseQty(quantityInput, maxStock);
                });

                quantityInput.nextElementSibling.nextElementSibling.addEventListener('click', function() {
                    decreaseQty(quantityInput);
                });

                quantityInput.dispatchEvent(new Event('input'));
            });

            function handleQuantityChange(input, maxStock) {
                var value = parseInt(input.value) || 0;
                var stock = parseInt(input.dataset.stock) || 0;

                if (value > stock) {
                    input.value = stock;
                } else if (value > maxStock) {
                    input.value = maxStock;
                }
            }

            function increaseQty(quantityInput, maxStock) {
                var currentQty = parseInt(quantityInput.value) || 0;

                if (currentQty < maxStock) {
                    quantityInput.value = currentQty + 1;
                    quantityInput.dispatchEvent(new Event('input'));
                }
            }

            function decreaseQty(quantityInput) {
                var currentQty = parseInt(quantityInput.value) || 0;
                if (currentQty > 1) {
                    quantityInput.value = currentQty - 1;
                    quantityInput.dispatchEvent(new Event('input'));
                }
            }
        });
    </script>
@endsection
