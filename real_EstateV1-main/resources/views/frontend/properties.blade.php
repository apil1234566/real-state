@extends('frontend.layouts.master')
@section('stylesheet')
@endsection
@section('content')
<!-- ======= Intro Single ======= -->
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="title-single-box">
                    <h1 class="title-single">Our Amazing Properties</h1>
                    <span class="color-text-a">Grid Properties</span>
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('/')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Properties Grid
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section><!-- End Intro Single-->
<!-- ======= Property Grid ======= -->
@if($properties->isNotEmpty())
<section class="property-grid grid">
    <div class="container">
        <div class="row">
            @foreach ( $properties as $property)
            <div class="col-md-4">
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
                                    <a href="{{ route('single_property',$property->id) }}">
                                        {{$property->title }}</a>
                                </h2>
                            </div>
                            <div class="card-body-a">
                                <div class="price-box d-flex">
                                    <span class="price-a">Nrs. {{number_format($property->price)}}</span>
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
            </div>
            @endforeach
        </div>
        @if ($properties->links())
        <div class="row">
            <div class="col-sm-12">
                <nav class="pagination-a">
                    <ul class="pagination justify-content-end">
                        {{ $properties->links() }}
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
</section><!-- End Property Grid Single-->
@else
<section class="property-grid grid">
    <div class="container">
    <h1>No Data</h1>
    </div>
</section>
@endif


@endsection
@section('scripts')
@endsection
