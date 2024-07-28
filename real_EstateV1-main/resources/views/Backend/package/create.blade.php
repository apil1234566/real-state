@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 p-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 nodecorationlist">
                    <li class="breadcrumb-item green"><a href="{{route('home')}}" class="green"><i class="fas fa-home mr-2"></i>Home</a></li>
                    <li class="breadcrumb-item green"><a href="{{route('notice.index')}}" class="green">Notice</a>
                    </li>
                    <li class="breadcrumb-item active gray" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    @include('_partialstest._messages')

    <div class="card mb-2">
        <div class="card-body">
            <div class="row welcomecard">
                <div class="col-12">
                    <h5 class="pb-2">Create Package</h5>
                    <form class="custom-hover" action="{{route('package.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="title" class="gray">Customer Name</label>
                                    <input type="text" class="form-control" id="title" readonly  placeholder="Title" name="user_id" value="{{$user->name}}">
                                    <input type="hidden" class="form-control" id="" readonly placeholder="Title" name="user_id" value="{{$user->id}}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="title" class="gray">Package Name</label>
                                    <input type="text" class="form-control" id="title" readonly  placeholder="Title" name="package_title" value="{{$package->name}}">
                                    <input type="hidden" name="package_id" value="{{$package->id}}">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title" class="gray">Package Description</label>
                                    <input type="text" class="form-control" id="title" readonly  placeholder="Title" name="" value="{{$package->description}}">

                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="title" class="gray">Package Price</label>
                                    <input type="text" class="form-control" id="title"  readonly placeholder="Title" name="" value="{{$package->price}}">

                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="title" class="gray">Issue Date</label>
                                    <input type="text" class="form-control" id="title" readonly  placeholder="Title" name="issue_date" value="{{$today_date}}">

                                </div>
                            </div>
                             <div class="col-4">
                                 <div class="form-group">
                                     <label for="title" class="gray">Expire Date</label>
                                     <input type="text" class="form-control" id="title" readonly  placeholder="Title" name="expire_date" value="{{$expire_date}}">
                                 </div>
                             </div>
                        </div>
                        <div class="row pl-3">
                            <div class="col-12 ">
                                <a href="{{route('property.index')}}" class="btn btn-danger float-right ml-2">Cancel</a>
                                <button type="submit" id="checkBtn" class="btn btn-green float-right">Confirm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('js')
<script>
</script>
@endsection
