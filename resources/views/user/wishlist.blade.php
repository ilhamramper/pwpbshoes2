@extends('layoutsuser.template')

@section('user')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Wishlist</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('wishlist') }}">Wishlist</a>
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
                        width: 30%;
                    }

                    .name-col {
                        width: 30%;
                    }

                    .price-col {
                        width: 20%;
                    }

                    .actions-col {
                        width: 20%;
                    }
                </style>
                <div class="table-responsive">
                    @if (Auth::check())
                        @if (count($wishlistItems) > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-col">Product</th>
                                        <th class="name-col">Name</th>
                                        <th class="price-col">Price</th>
                                        <th class="actions-col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wishlistItems as $wishlistItem)
                                        <tr>
                                            <td class="product-col">
                                                <div class="d-flex justify-content-center">
                                                    <img src="{{ asset('storage/' . $wishlistItem->item->image) }}"
                                                        alt="{{ $wishlistItem->item->name }}"
                                                        style="width: 150px; height: 150px; object-fit: fill;">
                                                </div>
                                            </td>
                                            <td class="name-col">
                                                <h5>{{ $wishlistItem->item->name }}</h5>
                                            </td>
                                            <td class="price-col">
                                                <h5>
                                                    @if ($wishlistItem->item->discount === null)
                                                        ${{ number_format($wishlistItem->item->price, 2) }}
                                                    @else
                                                        ${{ number_format($wishlistItem->item->dprice, 2) }}
                                                    @endif
                                                </h5>
                                            </td>
                                            <td class="actions-col">
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('addCart', ['id' => $wishlistItem->item->id]) }}"
                                                        class="btn btn-warning">
                                                        <span class="ti-bag"></span>
                                                    </a>
                                                    <form action="{{ route('destroyWishlist', $wishlistItem->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger ml-1">
                                                            <span class="ti-trash"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="product-col">Product</th>
                                        <th class="name-col">Name</th>
                                        <th class="price-col">Price</th>
                                        <th class="actions-col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">
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
                                    <th class="actions-col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center">
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
