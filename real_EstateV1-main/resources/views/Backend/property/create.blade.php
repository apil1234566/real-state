@extends('layouts.master')

@section('content')
<style>
    .preview-image {
        max-width: 100px;
        /* Adjust the size of the preview images */
        max-height: 100px;
        margin: 5px;
    }

</style>

<div class="container-fluid pl-3 pr-3">
    <div class="row">
        <div class="col-12 p-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 nodecorationlist">
                    <li class="breadcrumb-item green"><a href="{{route('home')}}" class="green"><i class="fas fa-home mr-2"></i>Home</a></li>
                    <li class="breadcrumb-item green"><a href="{{route('property.index')}}" class="green">All Property</a>
                    </li>
                    <li class="breadcrumb-item active gray" aria-current="page">Create Property</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row welcomecard">
                            <div class="col-12">
                                <h5 class="pb-2">Add Property Details</h5>
                                <form class="custom-hover" action="{{route('property.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">

                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label for="title" class="gray">Title</label>
                                                <input type="text" class="form-control" id="title" required placeholder="Great Room Available here" name="title" value="{{old('title')}}">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="title" class="gray">City</label>
                                                <select class="custom-select" name="city_id" id="city" onchange="selectCity(this);">
                                                    <option value="0" disabled selected>Select City</option>
                                                    @foreach($cities as $city)
                                                    <option value="{{$city->id}}" id="{{$city->id}}">{{$city->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                <label for="title" class="gray">Place</label>
                                                <select class="custom-select" id="select_place">
                                                    <option value="0" disabled selected>Select City First</option>
                                                </select>
                                                @foreach($cities as $city)
                                                <select class="places custom-select" id="{{'pid'.$city->id}}" style="display: none;">
                                                    <option value="0" disabled selected>Select place</option>
                                                    @foreach($city->places as $place)
                                                    <option value="{{$place->id}}" id="{{$place->id}}">{{$place->name}}</option>
                                                    @endforeach
                                                </select>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="price" class="gray">Price</label>
                                                <input type="number" class="form-control" id="price" required placeholder="Rs. 5000" name="price" value="{{ old('price') }}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="property_area" class="gray">Property Area</label>
                                                <input type="number" class="form-control" id="property_area" required placeholder="In Meter Square" name="property_area" value="{{old('property_area')}}">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="total_rooms" class="gray">Total Number of Room</label>
                                                <input type="number" class="form-control" id="total_rooms" required placeholder="5" name="total_rooms" value="{{old('total_rooms')}}">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label for="category" class="gray">Select Room Type</label>
                                                <select class="custom-select" name="category_id" id="category">
                                                    <option disabled selected>Select Category</option>
                                                    @foreach($categories as $categories)
                                                    <option value="{{$categories->id}}" id="{{$categories->id}}">{{$categories->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 p-2">
                                            <div class="form-group">
                                                <label for="article-ckeditor" class="gray">Description</label>
                                                <textarea class="form-control" id="article-ckeditor" name="description" rows="3" required>{{old('description')}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="form-group col-md-12">
                                                <label for="property_plan">Floor Plan</label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <img src="{{ asset('backend/assets/img/logo.jpg') }}" alt="plan Image" class="rounded" id="property_plan" width="150px">

                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="file" class="btn form-control pt-0 pl-0" name="property_plan" onchange="document.getElementById('property_plan').src = window.URL.createObjectURL(this.files[0])" accept="property_plan/*" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="form-group col-md-12">
                                                <label for="panoromic_image">360 View Image</label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <img src="{{ asset('backend/assets/img/logo.jpg') }}" alt="plan Image" class="rounded" id="panoromic_image" width="150px">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <input type="file" class="btn form-control pt-0 pl-0" name="panoromic_image" onchange="document.getElementById('panoromic_image').src = window.URL.createObjectURL(this.files[0])" accept="property_plan/*" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="room_images" class="gray">Upload Property Images </label><br>
                                                        <input type="file" name="images[]" class="btn form-control pt-0 pl-0" id="room_images" multiple accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="image_preview"></div> <!-- Container to display image previews -->
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="form-group">
                                                <label for="role" class="gray">Facilities</label>
                                                <br>
                                                @foreach($facilities as $facility)
                                                <div class="form-check form-check-inline">
                                                    <input class="custom-checkbox form-check-input " name="facilities[]" type="checkbox" id="{{$facility->name}}" value="{{$facility->id}}">
                                                    <label class="form-check-label" for="{{$facility->name}}">{{$facility->name}}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row pl-3">
                                        <div class="col-12 ">
                                            <button type="submit" id="checkBtn" class="btn btn-green float-right">
                                                Create
                                            </button>
                                        </div>
                                    </div>

                                </form>

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
<script>
    function selectCity(city) {
        //Not displaying places before selecting city
        places = document.getElementsByClassName('places');
        for (var i = 0; i < places.length; i++) {
            places[i].style.display = "none";
        }
        //city is selected
        if (city) {
            //(first/default) select is removed
            document.getElementById('select_place').style.display = "none";

            document.getElementsByName("place_id").forEach(function(element) {
                element.removeAttribute("name");
            });

            if (city.value == 0) {
                document.getElementById("select_place").style.display = "block";
            }
            //places according to city is displayed
            document.getElementById('pid' + city.value).setAttribute("name", "place_id")
            document.getElementById('pid' + city.value).style.display = "block";
        }
    }
    document.getElementById('room_images').addEventListener('change', function() {
        var files = this.files;
        var preview = document.getElementById('image_preview');

        preview.innerHTML = ''; // Clear previous previews

        if (files) {
            [].forEach.call(files, function(file) {
                var reader = new FileReader();

                reader.onload = function(event) {
                    var img = document.createElement('img');
                    img.classList.add('preview-image');
                    img.src = event.target.result;
                    preview.appendChild(img);
                }

                reader.readAsDataURL(file);
            });
        }
    });
</script>

<script src="//cdn.ckeditor.com/4.4.7/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('article-ckeditor');

</script>
@endsection
