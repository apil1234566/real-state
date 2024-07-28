@extends('frontend.layouts.master')
@section('stylesheet')
@endsection
@section('content')
<!-- =======Intro Single ======= -->
<section class="intro-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8">
                <div class="title-single-box">
                    <h1 class="title-single">Our Amazing Agents</h1>
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
                            Agents Grid
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section><!-- End Intro Single-->

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
                                    <strong>Phone: </strong> {{ $agent->phone }}
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
</section><!-- End Agents Grid-->
@endif

@endsection
@section('scripts')
@endsection
