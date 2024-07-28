@extends('layouts.master')

@section('content')
<style>
    /* Modal Header */
    .modal-header {
        background-color: #007bff;
        color: #fff;
        border-bottom: none;
    }

    /* Modal Title */
    .modal-title {
        font-size: 1.5rem;
    }

    /* Modal Body */
    .modal-body {
        padding: 20px;
    }

    /* Package Card */
    .card {
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 1.2rem;
        margin-bottom: 10px;
    }

    .card-text {
        color: #555;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .card-price {
        font-size: 1.1rem;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 10px;
    }

    .card button {
        /* background-color: #007bff; */
        border: none;
        color: #fff;
        /* padding: 8px 16px; */
        border-radius: 20px;
        transition: background-color 0.3s ease;
    }

    .card button:hover {
        background-color: #0056b3;
    }

</style>



    <div class="container-fluid pl-3 pr-3">
        <div class="row">
            <div class="col-12 p-0">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 nodecorationlist">
                        <li class="breadcrumb-item green"><a href="{{route('home')}}" class="green"><i
                                    class="fas fa-home mr-2"></i>Home</a></li>
                        <li class="breadcrumb-item active gray" aria-current="page">Property</li>
                    </ol>
                </nav>
            </div>
        </div>

        @include('_partialstest._messages')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">All Property
                            <button type="button" class="btn btn-sm btn-primary float-right ml-2" data-toggle="modal" data-target="#packageModal">
                                <i class="fas fa-plus"></i> Subscribe
                            </button>

                            <a href="{{route('property.create')}}" type="button" class="btn btn-sm btn-green float-right">
                                <i class="fas fa-plus"></i> Add Property
                            </a>
                        </div>
                        <div class="modal fade" id="packageModal" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="packageModalLabel">Choose a Package</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            @foreach($packages as $package)
                                            <div class="col-md-6 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $package['name'] }}</h5>
                                                        <p class="card-text">{{ $package['description'] }}</p>
                                                        <p class="card-text">Price: Nrs.{{ $package['price'] }}</p>
                                                        <p class="card-text">Duration: {{ ucfirst($package['duration']) }}</p>
                                                        <a class="btn btn-primary" href="{{route('package.create',$package['id'])}}">Subscribe</a>

                                                        {{-- <button type="button" ></button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="card-body mt-0">
                            <div class="table-responsive">
                                <table id="myTable"
                                       class="table table-striped table-hover table-responsive-sm table-sm">
                                    <thead class="bg-green">
                                    <tr>
                                        <th>Property</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($properties as $property)

                                        <tr>
                                            <td>{{$property->title}}</td>
                                            <td>{{$property->created_at}}</td>
                                            <td class="d-inline-flex">

                                                <a type="button" class="btn btn-sm btn-default float-right" href="{{route('property.edit',$property->id)}}">
                                                    <i class="fas fa-edit" style="color: #1abb9c"></i>
                                                </a>

                                                <form action="{{route('property.destroy',$property->id)}}"
                                                      method="post" class="form-delete"
                                                      style="display: inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-sm btn-default"
                                                            onclick="return confirm('Are you sure?');"><i
                                                            class="fas fa-trash" style="color: #dc1201"></i>
                                                    </button>
                                                </form>
                                                <a href="{{route('property.show',$property->id)}}" class="pt-1 pl-1"><i class="far fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
@endsection
