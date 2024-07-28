@extends('frontend.layouts.master')
@section('content')
<!-- ======= Intro Section ======= -->
<div class="intro intro-carousel swiper position-relative">
    <div class="swiper-wrapper">
        <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url({{ asset('backend/assets/img/slide-1.jpg') }})">
            <div class="overlay overlay-a"></div>
            <div class="intro-content display-table">
                <div class="table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="intro-body">
                                    {{-- <p class="intro-title-top">Doral, Florida
                                        <br> 78345
                                    </p>
                                    <h1 class="intro-title mb-4 ">
                                        <span class="color-b">204 </span> Mount
                                        <br> Olive Road Two
                                    </h1>
                                    <p class="intro-subtitle intro-price">
                                        <a href="#"><span class="price-a">rent | $ 12.000</span></a>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url({{ asset('backend/assets/img/slide-2.jpg') }})">
            <div class="overlay overlay-a"></div>
            <div class="intro-content display-table">
                <div class="table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="intro-body">
                                    {{-- <p class="intro-title-top">Doral, Florida
                                        <br> 78345
                                    </p>
                                    <h1 class="intro-title mb-4">
                                        <span class="color-b">204 </span> Rino
                                        <br> Venda Road Five
                                    </h1>
                                    <p class="intro-subtitle intro-price">
                                        <a href="#"><span class="price-a">rent | $ 12.000</span></a>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-slide carousel-item-a intro-item bg-image" style="background-image: url({{ asset('backend/assets/img/slide-3.jpg') }})">
            <div class="overlay overlay-a"></div>
            <div class="intro-content display-table">
                <div class="table-cell">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="intro-body">
                                    {{-- <p class="intro-title-top">Doral, Florida
                                        <br> 78345
                                    </p>
                                    <h1 class="intro-title mb-4">
                                        <span class="color-b">204 </span> Alira
                                        <br> Roan Road One
                                    </h1>
                                    <p class="intro-subtitle intro-price">
                                        <a href="#"><span class="price-a">rent | $ 12.000</span></a>
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
</div><!-- End Intro Section -->

<main id="main">
    <!-- ======= Latest Properties Section ======= -->
    @if($properties->isNotEmpty())
    <section class="section-property section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a">Latest Properties</h2>
                        </div>
                        <div class="title-link">
                            <a href="{{route('properties')}}">All Property
                                <span class="bi bi-chevron-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="property-carousel" class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($properties as $property)
                    <a href="{{ route('single_property',$property->id) }}">
                        <div class="carousel-item-b swiper-slide">
                            <div class="card-box-a card-shadow">
                                @foreach ($property->images as $key => $image)
                                @if ($key == 0)
                                <div class="img-box-a">
                                    <img src="{{ (($image->image != '') && file_exists(public_path('images/property/'.$image->image))) ? asset('images/property/'.$image->image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-a img-fluid">
                                </div>
                                @endif
                                @endforeach
                                <div class="card-overlay">
                                    <div class="card-overlay-a-content">
                                        <div class="card-header-a">
                                            <h2 class="card-title-a">
                                                <a href="{{ route('single_property',$property->id) }}">{{ $property->title }}</a>

                                            </h2>
                                        </div>
                                        <div class="card-body-a">
                                            <div class="price-box d-flex">
                                                <span class="price-a">Price Rs. {{ $property->price }}</span>
                                            </div>
                                            <a href="{{ route('single_property',$property->id) }}" class="link-a">Click here to view
                                                <span class="bi bi-chevron-right"></span>
                                            </a>
                                        </div>
                                        <div class="card-footer-a">
                                            <ul class="card-info d-flex justify-content-around">
                                                <li>
                                                    <h4 class="card-info-title">Area</h4>
                                                    <span>{{ $property->property_area }} m
                                                        <sup>2</sup>
                                                    </span>
                                                </li>
                                                <li>
                                                    <h4 class="card-info-title">Rooms</h4>
                                                    <span>{{ $property->total_rooms }}</span>
                                                </li>
                                                <li>
                                                    <h4 class="card-info-title">Views</h4>
                                                    <span>{{ $property->views }}</span>
                                                </li>
                                                <li>
                                                    <h4 class="card-info-title">Type</h4>
                                                    <span>{{$property->category->name}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End carousel item -->
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="propery-carousel-pagination carousel-pagination"></div>
        </div>
    </section><!-- End Latest Properties Section -->
    @endif

    <!-- ======= Agents Section ======= -->
    @if ($agents->isNotEmpty())
    <section class="section-agents section-t8">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a">Best Agents</h2>
                        </div>
                        <div class="title-link">
                            <a href="agents-grid.html">All Agents
                                <span class="bi bi-chevron-right"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($agents as $agent)
                <div class="col-md-4">
                    <div class="card-box-d">
                        <div class="card-img-d">
                            <img src="{{ (($agent->image != '') && file_exists(public_path('images/owner/profile/'.$agent->image))) ? asset('images/owner/profile/'.$agent->image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-d img-fluid" >
                        </div>
                        <div class="card-overlay card-overlay-hover">
                            <div class="card-header-d">
                                <div class="card-title-d align-self-center">
                                    <h3 class="title-d">
                                        <a href="{{route('agent.detail',$agent->id)}}" class="link-two">{{ $agent->user->name}}</a>
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body-d">
                                <p class="content-d color-text-a">
                                   {!! \Illuminate\Support\Str::limit($agent->description, 20, '...') !!}
                                </p>
                                <div class="info-agents color-a">
                                    <p>
                                        <strong>Phone: </strong> {{ $agent->phone}}
                                    </p>
                                    <p>
                                        <strong>Email: </strong> {{$agent->user->email}}
                                    </p>
                                </div>
                            </div>
                            <div class="card-footer-d">
                                <div class="socials-footer d-flex justify-content-center">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="{{route('agent.detail',$agent->id)}}" class="link-one">
                                                <i class="bi bi-facebook" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{route('agent.detail',$agent->id)}}" class="link-one">
                                                <i class="bi bi-twitter" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{route('agent.detail',$agent->id)}}" class="link-one">
                                                <i class="bi bi-instagram" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="{{route('agent.detail',$agent->id)}}" class="link-one">
                                                <i class="bi bi-linkedin" aria-hidden="true"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section><!-- End Agents Section -->
    @endif
    <!-- ======= Testimonials Section ======= -->
    @if($testimonials->isNotEmpty())
    <section class="section-testimonials section-t8 nav-arrow-a">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-wrap d-flex justify-content-between">
                        <div class="title-box">
                            <h2 class="title-a">Testimonials</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div id="testimonial-carousel" class="swiper">
                <div class="swiper-wrapper">
                    @foreach ($testimonials as $testimonial )
                    <div class="carousel-item-a swiper-slide">
                        <div class="testimonials-box">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="testimonial-img">
                            {{-- <img src="{{ (($testimonial->user->owner->image != '') && file_exists(public_path('images/owner/profile/'.$testimonial->user->owner->image))) ? asset('images/owner/profile/'.$testimonial->user->owner->image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-d img-fluid"> --}}


                                        <img src="{{ (($testimonial->user->image_id != '') && file_exists(public_path('images/property/'.$testimonial->user->image_id))) ? asset('images/property/'.$testimonial->user->image_id) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="testimonial-ico">
                                        <i class="bi bi-chat-quote-fill"></i>
                                    </div>
                                    <div class="testimonials-content">
                                        <p class="testimonial-text">
                                            {!! $testimonial->description !!}
                                        </p>
                                    </div>
                                    <div class="testimonial-author-box">
                                        <img src="{{ (($testimonial->user->image_id != '') && file_exists(public_path('images/property/'.$testimonial->user->image_id))) ? asset('images/property/'.$testimonial->user->image_id) : asset('backend/assets/img/logo.jpg') }}" alt="" class="testimonial-avatar">
                                        <h5 class="testimonial-author">{{ $testimonial->user->name }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End carousel item -->


                    @endforeach


                </div>
            </div>
            <div class="testimonial-carousel-pagination carousel-pagination"></div>

        </div>
    </section><!-- End Testimonials Section -->
    @endif

</main><!-- End #main -->

<!-- ======= Footer ======= -->

@endsection
