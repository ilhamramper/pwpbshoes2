@extends('layoutsuser.template')

@section('user')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Product Details Page</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('shop') }}">Shop<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('product.detail', $item->id) }}">Product Detail</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Single Product Area =================-->
    <div class="product_image_area mb-5">
        <div class="container">
            <div class="row s_product_inner">
                <div class="col-lg-6">
                    <img class="img-fluid" src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                        style="width: 500px; height: 500px; object-fit: fill;">
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <div class="s_product_text">
                        <h3>{{ $item->name }}</h3>
                        <h2>
                            @if ($item->discount === null)
                                ${{ number_format($item->price, 2) }}
                            @else
                                ${{ number_format($item->dprice, 2) }}
                            @endif
                        </h2>
                        <ul class="list">
                            <li><a href="#">Stock : {{ $item->stock }}</a></li>
                        </ul>
                        <p>{{ $item->description }}</p>
                        <div class="card_area d-flex align-items-center">
                            <a class="primary-btn" href="{{ route('addCart', ['id' => $item->id]) }}">Add to Cart</a>
                            <a class="icon_btn" href="{{ route('addWishlist', ['id' => $item->id]) }}"><i
                                    class="lnr lnr lnr-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================End Single Product Area =================-->
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
