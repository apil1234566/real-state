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
                    <h1 class="title-single">{{$searchKeyword}}</h1>

                    <span class="color-text-a">Results</span>
                </div>
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
                                    <span class="price-a">Nrs. {{ number_format($property->price, 2) }}</span>
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
{{-- @else
<section class="property-grid grid">
    <div class="container">
        <h1>No Data</h1>
    </div>
</section> --}}
@endif
@if($agents->isNotEmpty())
<!-- ======= Agents Grid ======= -->
<section class="agents-grid grid">
    <div class="container">
        <div class="row">
            @foreach ($agents as $agent)
            <div class="col-md-4">
                <div class="card-box-d">
                    <div class="card-img-d">
                        <img src="{{ (($agent->image_id != '') && file_exists(public_path('images/property/'.$agent->image_id))) ? asset('images/property/'.$agent->image_id) : asset('backend/assets/img/logo.jpg') }}" alt="" class="img-d img-fluid">
                    </div>
                    <div class="card-overlay card-overlay-hover">
                        <div class="card-header-d">
                            <div class="card-title-d align-self-center">
                                <h3 class="title-d">
                                    <a href="{{route('agent.detail',$agent->id)}}" class="link-two">{{$agent->name}}
                                </h3>
                            </div>
                        </div>
                        <div class="card-body-d">
                            <p class="content-d color-text-a">
                                {{$agent->description}}
                            </p>
                            <div class="info-agents color-a">
                                <p>
                                    <strong>Phone: </strong> +54 356 945234
                                </p>
                                <p>
                                    <strong>Email: </strong> agents@example.com
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
        @if ($agents->links())
        <div class="row">
            <div class="col-sm-12">
                <nav class="pagination-a">
                    <ul class="pagination justify-content-end">
                        {{ $agents->links() }}
                    </ul>
                </nav>
            </div>
        </div>
        @endif
    </div>
</section>
@endif
@endsection
@section('scripts')
@endsection

