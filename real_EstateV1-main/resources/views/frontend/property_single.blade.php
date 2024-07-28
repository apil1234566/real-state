@extends('frontend.layouts.master')
@section('stylesheet')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />
<style>
    .rate {
        font-size: 24px;
        /* Adjust font size as needed */
    }

    .rating-star {
        color: gold;
        cursor: pointer;
    }

</style>
@endsection
@section('content')
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="title-single-box">
                    <h1 class="title-single">{{ $property->title }}</h1>
                    <span class="color-text-a">{{ $property->city->name }}, {{ $property->place->name }}</span>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{url('/')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="property-grid.html">Properties</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $property->title }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section><!-- End Intro Single-->

<!-- ======= Property Single ======= -->
<section class="property-single nav-arrow-b">
    <div class="container">
        @if($property->images->isnotEmpty())
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div id="property-single-carousel" class="swiper">
                    <div class="swiper-wrapper">
                        @foreach($property->images as $image)
                        <div class="carousel-item-b swiper-slide">
                            <img src="{{ (($image->image != '') && file_exists(public_path('images/property/'.$image->image))) ? asset('images/property/'.$image->image) : asset('backend/assets/img/logo.jpg') }}" alt="" height="500px" width="800px">
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="property-single-carousel-pagination carousel-pagination"></div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-sm-12">
                <div class="row justify-content-between">
                    <div class="col-md-5 col-lg-4">
                        <div class="property-price d-flex justify-content-center foo">
                            <div class="card-header-c d-flex">
                                <div class="card-box-ico">
                                    <span class="bi bi-cash">Nrs</span>
                                </div>
                                <div class="card-title-c align-self-center">
                                    <h5 class="title-c">{{ number_format($property->price, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="property-summary">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="title-box-d section-t4">
                                        <h3 class="title-d">Quick Summary</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="summary-list">
                                <ul class="list">
                                    <li class="d-flex justify-content-between">
                                        <strong>Property ID:</strong>
                                        <span>{{$property->id }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Location:</strong>
                                        <span>{{ $property->city->name }}, {{ $property->place->name }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Property Type:</strong>
                                        <span>{{$property->category->name}}</span>

                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Status:</strong>
                                        <span>{{ $property->status == 0 ? 'For Sale':'Sold Out' }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Area:</strong>
                                        <span>{{ $property->property_area }}m
                                            <sup>2</sup>
                                        </span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Rooms:</strong>
                                        <span>{{ $property->total_rooms }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between">
                                        <strong>Views:</strong>
                                        <span>{{ $property->views }}</span>
                                    </li>

                                    <li class="d-flex justify-content-between">
                                        <strong>Rating:</strong>
                                        <div class="rate">
                                            @php
                                            // $avgRating = getAvgRating($latest_product->id);
                                            $fullStars = floor($avgRating); // Get the integer part for full stars
                                            $halfStar = ceil($avgRating - $fullStars); // Get the fractional part for the half star
                                            $emptyStars = 5 - $fullStars - $halfStar; // Calculate the number of empty stars
                                            @endphp

                                            @for ($i = 1; $i <= 5; $i++) @if ($i <=$fullStars) <span class="rating-star" style="color: gold; cursor: pointer;">&#9733;</span>
                                                @elseif ($i == $fullStars + 1 && $halfStar)
                                                <span class="rating-star" style="color: gold; cursor: pointer;">&#9733;&#9734;</span>
                                                @else
                                                <span class="rating-star" style="color: gold; cursor: pointer;">&#9734;</span>
                                                @endif
                                                @endfor
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-7 section-md-t3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title-box-d">
                                    <h3 class="title-d">Property Description</h3>
                                </div>
                            </div>
                        </div>
                        <div class="property-description">
                            <p class="description color-text-a">
                                {!! $property->description !!}
                            </p>
                        </div>
                        <div class="row section-t3">
                            <div class="col-sm-12">
                                <div class="title-box-d">
                                    <h3 class="title-d">Facilities</h3>
                                </div>
                            </div>
                        </div>

                        @if ($property->facilities->isNotEmpty())
                        <div class="amenities-list color-text-a">
                            <ul class="list-a no-margin">
                                @foreach($property->facilities as $facility)
                                <li>{{$facility->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-12 col-lg-7 section-md-t3 mt-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="title-box-d">
                                    <h3 class="title-d">Property 360 view </h3>
                                </div>
                                <a href="{{ route('property_panoromic',$property->id) }}">
                                    <img src="{{ (($property->panoromic_image != '') && file_exists(public_path('images/property/'.$property->panoromic_image))) ? asset('images/property/'.$property->panoromic_image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{$property->city->latitude}}" id="city_latitude">
            <input type="hidden" value="{{$property->city->longitude}}" id="city_longitude">

            <input type="hidden" value="{{$property->place->latitude}}" id="room_latitude">
            <input type="hidden" value="{{$property->place->longitude}}" id="room_longitude">

            <input type="hidden" name="room_id" id="room_id" value="{{$property->id}}">
            <input type="hidden" name="title" id="title" value="{{$property->title}}">

            @if (Auth()->user())
            <input type="hidden" name="auth_id" id="auth_id" value="{{auth()->id()}}">
            @endif
            <input type="hidden" name="" id="property_id" value="{{$property->id}}">

            <div class="col-md-10 offset-md-1">
                <ul class="nav nav-pills-a nav-pills mb-3 section-t3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-video-tab" data-bs-toggle="pill" href="#pills-video" role="tab" aria-controls="pills-video" aria-selected="true">Video</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="pills-plans-tab" data-bs-toggle="pill" href="#pills-plans" role="tab" aria-controls="pills-plans" aria-selected="false">Floor Plans</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="pills-map-tab" data-bs-toggle="pill" href="#pills-map" role="tab" aria-controls="pills-map" aria-selected="false">Map</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                        <iframe src="https://player.vimeo.com/video/73221098" width="100%" height="460" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                    <div class="tab-pane fade " id="pills-plans" role="tabpanel" aria-labelledby="pills-plans-tab">
                        <img src="{{ (($property->property_plan != '') && file_exists(public_path('images/property/'.$property->property_plan))) ? asset('images/property/'.$property->property_plan) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-fluid">
                    </div>
                    <div class="tab-pane fade" id="pills-map" role="tabpanel" aria-labelledby="pills-map-tab">
                        <div class="my-5 h4">
                            Map
                            <span>
                                <button class="btn btn-sm btn-outline-dark float-right show_map">
                                    <i id="minimizer_map" class="fas fa-angle-down fa-lg gray"></i>
                                </button>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <div id='map' style='width:1000px; height: 50vh;' class="maps m-auto mt-5"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="row section-t3">
                    <div class="col-sm-12">
                        <div class="title-box-d">
                            <h3 class="title-d">Contact Agent</h3>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        {{-- <img src="{{ (($agent->image != '') && file_exists(public_path('images/owner/profile/'.$agent->image))) ? asset('images/owner/profile/'.$agent->image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="agent-avatar img-fluid"> --}}


                        <img src="{{ (($property->owner->image_id != '') && file_exists(public_path('images/property/'.$property->owner->image_id))) ? asset('images/property/'.$property->owner->image_id) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-fluid">
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="property-agent">
                            <h4 class="title-agent">{{$property->user->name}}</h4>
                            <p class="color-text-a">
                                {!! \Illuminate\Support\Str::limit($property->owner->description, 20, '...') !!}

                            </p>
                            <ul class="list-unstyled">
                                <li class="d-flex justify-content-between">
                                    <strong>Phone:</strong>
                                    <span class="color-text-a">{{ $property->owner->phone }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>City:</strong>
                                    <span class="color-text-a">{{ $property->owner->city->name }}</span>
                                </li>
                                <li class="d-flex justify-content-between">
                                    <strong>Email:</strong>
                                    <span class="color-text-a">{{ $property->user->email }}</span>
                                </li>
                            </ul>
                            <div class="col-md-12 mt-5">
                                <a href="{{route('applicant.create',$property->id)}}" class="btn btn-primary btn-sm">Private Chat</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Property Single-->
@endsection
@section('scripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
<script>
    var city_latitude = document.getElementById('city_latitude').value;
    var city_longitude = document.getElementById('city_longitude').value;

    var room_latitude = document.getElementById('room_latitude').value;
    var room_longitude = document.getElementById('room_longitude').value;

    var user_city = [city_longitude, city_latitude];
    var room_place = [room_longitude, room_latitude];
    mapboxgl.accessToken = 'pk.eyJ1IjoiZXhwb3VuZGVyMTIzIiwiYSI6ImNrODJwY3hjeTEzZW0zZm5xeHJxZHQxd3gifQ.7MCsao35-JomeQ69Yg0ecQ';
    var map = new mapboxgl.Map({
        container: 'map'
        , style: 'mapbox://styles/mapbox/streets-v11', //v9
        center: user_city
        , zoom: 10
    });

    map.on('load', function() {
        addMarker(room_place, 'load');
    });

    let markerPopup = new mapboxgl.Popup({
            offset: 25
        })
        .setHTML("Property location ");

    let markerPopup2 = new mapboxgl.Popup({
            offset: 25
        })
        .setHTML(" Your current location ");

    function addMarker(ltlng, event) {
        marker = new mapboxgl.Marker({
                draggable: true
                , color: "#ccc"
            })
            .setLngLat(room_place)
            .setPopup(markerPopup) // sets a popup on this marker
            .addTo(map);
    }

    function addMarker2(ltlng, event) {
        marker = new mapboxgl.Marker({
                draggable: true
                , color: "#1abb9c"
            })
            // .setLngLat(seeker_place)
            .setPopup(markerPopup2) // sets a popup on this marker
            .addTo(map);
    }

</script>

@endsection
