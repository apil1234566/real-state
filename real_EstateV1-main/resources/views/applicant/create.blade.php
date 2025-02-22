@extends('layouts.master')

@section('content')

    <div class="container-fluid pl-3 pr-3">
        <div class="row">
            <div class="col-12 p-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 nodecorationlist">
                        <li class="breadcrumb-item green"><a href="{{route('home')}}" class="green"><i
                                    class="fas fa-home mr-2"></i>Home</a></li>
                        <li class="breadcrumb-item active gray" aria-current="page">Create Application</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('_partialstest._messages')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card mb-2">
                        <div class="card-body">
                            <div class="row welcomecard">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">About Property</div>
                                        @include('room.room_info')
                                    </div>
                                    <div class="card">
                                        <div class="card-header"><h5 class="pb-2 text-center">Add Application Message</h5></div>
                                        <form class="custom-hover" action="{{route('applicant.store',$property->id)}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-12 col-md-12 p-2">
                                                <div class="form-group">
                                                    <label for="article-ckeditor" class="gray"></label>
                                                    <textarea class="form-control" id="article-ckeditor"
                                                              name="message" rows="3"
                                                              required>{{old('message')}}</textarea>
                                                </div>
                                            </div>

                                          <div class="text-center"><button class="btn btn-sm btn-info mb-4 px-4"><i class="far fa-envelope"></i> Send Application</button></div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

    <script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('article-ckeditor');
    </script>
@endsection
