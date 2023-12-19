@extends('layoutsuser.template')

@section('user')
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Contact Us</h1>
                    <nav class="d-flex align-items-center">
                        <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="{{ route('contact') }}">Contact</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Contact Area =================-->
    <section class="contact_area section_gap_bottom">
        <div class="container">
            <div id="mapBox" class="mapBox" data-lat="40.701083" data-lon="-74.1522848" data-zoom="13"
                data-info="PO Box CT16122 Collins Street West, Victoria 8007, Australia." data-mlat="40.701083"
                data-mlon="-74.1522848">
            </div>
            <div class="row">
                @forelse ($contacks as $contack)
                <div class="col-lg-3">
                    <div class="contact_info">
                        <div class="info_item">
                            <i class="lnr lnr-home"></i>
                            <h6>Malang, Jawa Timur</h6>
                            <a href="https://maps.app.goo.gl/eqxkrw649WwxxDBKA" target="blank">{{ $contack->lokasi }}</a>
                        </div>
                        <div class="info_item">
                            <i class="lnr lnr-phone-handset"></i>
                            <h6><a href="#">Hubungi</a></h6>
                            <a href="https://wa.me/082132572180" target="blank">{{ $contack->nomor }}</a>
                        </div>
                        <div class="info_item">
                            <i class="lnr lnr-envelope"></i>
                            <h6><a href="#">Email</a></h6>
                            <a href="mailto:nasywa.muhammad@gmail.com" target="blank">{{ $contack->email }}</a>
                        </div>
                    </div>
                </div>
                @empty
                    
                @endforelse
                
                <div class="col-lg-9">
                    <form class="row contact_form" action="{{ route('masukan.store')}}" method="POST" id="contactForm"
                        novalidate="novalidate"  enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control  @error('nama') is-invalid @enderror" id="name"  value="{{ old('nama') }}"    name="nama"
                                    placeholder="Enter your name" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter your name'" >
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email"  value="{{ old('email') }}" name="email"
                                    placeholder="Enter email address" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter email address'">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control  @error('subject') is-invalid @enderror" id="subject"  value="{{ old('subject') }}" name="subject"
                                    placeholder="Enter Subject" onfocus="this.placeholder = ''"
                                    onblur="this.placeholder = 'Enter Subject'">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <textarea class="form-control  @error('message') is-invalid @enderror" name="laporan" id="message"  value="{{ old('message') }}" rows="1" placeholder="Enter Message"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                        </div>
                    
                </div>
            </form>
               
            </div>
        </div>
    </section>
    <!--================Contact Area =================-->
@endsection
