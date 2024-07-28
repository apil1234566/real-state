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
                    <h1 class="title-single">{{$agent->name}}</h1>
                    {{-- <span class="color-text-a">Agent Immobiliari</span> --}}
                </div>
            </div>
            <div class="col-md-12 col-lg-4">
                <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('/')}}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('agents')}}">Agents</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{$agent->name}}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section><!-- End Intro Single -->

<!-- ======= Agent Single ======= -->
<section class="agent-single">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="agent-avatar-box">
                            <img src="{{ (($agent->image != '') && file_exists(public_path('images/owner/profile/'.$agent->image))) ? asset('images/owner/profile/'.$agent->image) : asset('backend/assets/img/logo.jpg') }}" alt="" class="agent-avatar img-fluid">
                            
                        </div>
                    </div>
                    <div class="col-md-5 section-md-t3">
                        <div class="agent-info-box">
                            <div class="agent-title">
                                <div class="title-box-d">
                                    <h3 class="title-d">{{ $agent->name}}
                                    </h3>
                                </div>
                            </div>
                            <div class="agent-content mb-3">
                                <p class="content-d color-text-a">
                                    {!! $agent->description !!}
                                </p>
                                <div class="info-agents color-a">
                                    <p>
                                        <strong>Phone: </strong>
                                        <span class="color-text-a">{{$agent->phone}} </span>
                                    </p>
                                    <p>
                                        <strong>Email: </strong>
                                        <span class="color-text-a">{{ $agent->email }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="socials-footer">
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
            <div class="col-md-12 section-t8">
                <div class="title-box-d">
                    <h3 class="title-d">My Properties ({{$properties->isNotEmpty() ? $properties->count():0}})</h3>
                </div>
            </div>
            <div class="row property-grid grid">
                @if($properties->isNotEmpty())
                @foreach ($properties as $property)
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
                                        <span class="price-a">rent | $ 12.000</span>
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
                @endif
            </div>
        </div>
    </div>
</section><!-- End Agent Single -->
@endsection
@section('scripts')
@endsection
