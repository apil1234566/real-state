@extends('layouts.master')

@section('content')

<div class="container-fluid pl-3 pr-3">
    <div class="row">
        <div class="col-12 p-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0 nodecorationlist">
                    <li class="breadcrumb-item green"><a href="{{route('home')}}" class="green"><i class="fas fa-home mr-2"></i>Home</a></li>
                    <li class="breadcrumb-item green"><a href="{{route('property.index')}}" class="green">All Property</a>
                    </li>
                    <li class="breadcrumb-item active gray" aria-current="page">About Property
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    @include('_partialstest._messages')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    About Property
                                    {{-- @if(auth()->user()->role == 2)
                                            @if($property->is_bookmarked())
                                                <a href="{{route('remove_bookmark',$room->id)}}"
                                    class="btn btn-sm btn-dark float-right"> <i class="fas fa-bookmark"></i> Added
                                    to Bookmarks</a>
                                    @else
                                    <a href="{{route('add_bookmark',$room->id)}}" class="btn btn-sm btn-outline-dark float-right"><i class="far fa-bookmark"></i>
                                        Add to Bookmarks</a>
                                    @endif
                                    @endif --}}

                                </div>

                                @include('room.room_info')
                                <div class="col-md-12">
                                    <label for="">Property Plan</label>
                                    <div class="card-body ">
                                        <img src="{{ (($property->property_plan != '') && file_exists(public_path('images/property/'.$property->property_plan))) ? asset('images/property/'.$property->property_plan) : asset('backend/assets/img/logo.jpg') }}" height="300px" width="500px" class="mb-1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Panoraomic Image</label>
                                    <div class="card-body ">
                                        <img src="{{ (($property->panoromic_image != '') && file_exists(public_path('images/property/'.$property->panoromic_image))) ? asset('images/property/'.$property->panoromic_image) : asset('backend/assets/img/logo.jpg') }}" height="300px" width="500px" class="mb-1">
                                    </div>
                                </div>
                                <div class="card-header"><span>More Details</span>
                                    <span class="btn green btn-sm float-right">
                                        <i class="far fa-eye"></i> views : <strong>{{$property->views}}</strong>
                                    </span>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-muted pb-2">
                                        <b><i class="fas fa-book"></i> Property Description</b>
                                    </h5>
                                    <h6 style="text-align: justify" class="mb-5">{!!$property->description!!}</h6>
                                    <h6 class="green">
                                        <strong>Posted: {{$property->created_at}}</strong></h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header" onclick="minimize()">
                                    <h5>Images of Property
                                        <span class="float-right mr-2 topicons">
                                            <i id="minimizer" class="fas fa-angle-down fa-lg gray"></i>
                                        </span>
                                    </h5>
                                </div>
                                <div class="card-body card-collapse pb-5">
                                    @foreach($property->images as $image)
                                    <a href="#" class="image-link" data-image="{{ (($image->image != '') && file_exists(public_path('images/property/'.$image->image))) ? asset('images/property/'.$image->image) : asset('backend/assets/img/logo.jpg') }}">
                                        <img src="{{ (($image->image != '') && file_exists(public_path('images/property/'.$image->image))) ? asset('images/property/'.$image->image) : asset('backend/assets/img/logo.jpg') }}" height="80px" width="240px" class="mb-1">
                                    </a><br>
                                    @endforeach
                                </div>
                            </div>
                            
                            @if(auth()->user()->role == 2)
                            @isset($is_applied->status)
                            @if($is_applied->status != 'pending')
                            <btn class="btn btn-sm btn-dark btn-block "><i class="fas fa-check"></i>
                                {{$is_applied->status}}
                            </btn>
                            @else
                            <btn class="btn btn-sm btn-success btn-block "><i class="fas fa-check"></i> Pending
                            </btn>
                            @endif
                            @else
                            <a class="btn btn-sm btn-green btn-block" href="{{route('applicant.create',$property->id)}}">Apply For Room</a>
                            @endisset
                            @elseif(auth()->user()->id == $property->owner->user_id)
                            <a class="btn btn-sm btn-green btn-block" href="{{route('applicants.view',
                                       ['user_id'=>auth()->user()->id, 'room_id' =>$property->id])}}">
                                View Applicants</a>
                            @endif
                             @if(auth()->user()->role == 2)
                             <label for="rating" class="mt-5">How much you like this Property</label>
                             <select id="rating" class="custom-select mb-5" name="rating">
                                 @if(!$rating)
                                 <option value="" disabled selected>Give rating to this Property</option>
                                 <option value="1"> &#9733;</option>
                                 <option value="2"> &#9733; &#9733;</option>
                                 <option value="3"> &#9733; &#9733; &#9733;</option>
                                 <option value="4"> &#9733; &#9733; &#9733; &#9733;</option>
                                 <option value="5"> &#9733; &#9733; &#9733; &#9733; &#9733;</option>
                                 @else
                                 <option value="1" @if($rating->rating == 1) selected @endif> &#9733;
                                 </option>
                                 <option value="2" @if($rating->rating == 2) selected @endif>&#9733; &#9733;
                                 </option>
                                 <option value="3" @if($rating->rating == 3) selected @endif>&#9733; &#9733;
                                     &#9733;
                                 </option>
                                 <option value="4" @if($rating->rating == 4) selected @endif>&#9733; &#9733;
                                     &#9733; &#9733;
                                 </option>
                                 <option value="5" @if($rating->rating == 5) selected @endif>&#9733; &#9733;
                                     &#9733;&#9733; &#9733;
                                 </option>
                                 @endif
                             </select>
                             @endif

                            <!-- Modal -->
                            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="imageModalLabel">Image</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <img id="modalImage" src="" class="img-fluid" height="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(auth()->user()->role == 2)
                        <input type="hidden" value="{{$property->city->latitude}}" id="city_latitude">
                        <input type="hidden" value="{{$property->city->longitude}}" id="city_longitude">
                        <input type="hidden" value="{{$property->place->latitude}}" id="room_latitude">
                        <input type="hidden" value="{{$property->place->longitude}}" id="room_longitude">
                        <input type="hidden" value="{{auth()->user()->seeker->place->latitude}}" id="seeker_latitude">
                        <input type="hidden" value="{{auth()->user()->seeker->place->longitude}}" id="seeker_longitude">
                        <input type="hidden" name="property_id" id="property_id" value="{{$property->id}}">
                        <input type="hidden" name="title" id="title" value="{{$property->titleLimit}}">
                        <input type="hidden" name="auth_id" id="auth_id" value="{{auth()->id()}}">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{--**************************************COMMENTS************************************--}}
        {{-- <h4>comments
                <span>
                <button class="btn btn-sm btn-outline-dark float-right show_button">
                    <i id="minimizer_comment" class="fas fa-angle-down fa-lg gray"></i>
                </button>
            </span>
            </h4>
            <div class="comments ">

                <ul class="list-group list-group-flush" style="max-height: 500px; overflow-y: auto">
                    @foreach($property->comments as $comment)
                        <div class="comment-list card ">
                            <div class="card-body">
                                @include('comment.comment_list')
                                <button class="btn btn-sm btn-dark float-right mr-3 mt-2"
                                        onclick="toggleReply('{{$comment->id}}')">reply
        </button>
        <br>
    </div>
</div>


<div style="margin-left: 50px;" class="reply_form_{{$comment->id}} d-none">

    <form action="{{route('room.reply',$comment->id)}}" method="post" role="form">
        @csrf

        <div class="input-group mt-3">
            <input type="text" class="form-control" placeholder="add reply here ....." value="{{old('body')}}" name="body">
            <div class="input-group-append">
                <button class="btn btn-sm btn-green" type="submit" id="button-addon2">Post
                    reply
                </button>
            </div>
        </div>

    </form>

</div>
<br>

@foreach($comment->comments as $reply)
@include('comment.reply_list')
@endforeach

@endforeach
<br><br>
</ul>
@include('comment.comment_form')
</div> --}}

@if(auth()->user()->role == 2) {{-- wrapper for map--}}
<div class="my-5 h4">
    Map
    <span>
        <button class="btn btn-sm btn-outline-dark float-right show_map">
            <i id="minimizer_map" class="fas fa-angle-down fa-lg gray"></i>
        </button>
    </span>
</div>

@endif


</div>

</div>

<div id='map' style='width: 90%; height: 50vh;' class="maps m-auto mt-5"></div>
@endsection

@section('js')
<script>
    // JavaScript to handle image modal
    $(document).ready(function() {
        $('.image-link').click(function(e) {
            e.preventDefault();
            var imageUrl = $(this).data('image');
            $('#modalImage').attr('src', imageUrl);
            $('#imageModal').modal('show');
        });
    });

</script>
<script>
    function minimize() {
        obj = $('#minimizer');
        $('.card-collapse').slideToggle();
        $(obj).toggleClass('fa-angle-down');
        $(obj).toggleClass('fa-angle-up');
    }

    function toggleReply(commentId) {
        $('.reply_form_' + commentId).toggleClass('d-none');
    }

    $('.show_button').click(function() {
        obj = $('#minimizer_comment');
        $('.comments').toggleClass('d-none');
        $(obj).toggleClass('fa-angle-down');
        $(obj).toggleClass('fa-angle-up');
    })

    $('.show_map').click(function() {
        obj = $('#minimizer_map');
        $('.maps').toggleClass('d-none');
        $(obj).toggleClass('fa-angle-down');
        $(obj).toggleClass('fa-angle-up');
    })

    var city_latitude = document.getElementById('city_latitude').value;
    var city_longitude = document.getElementById('city_longitude').value;

    var room_latitude = document.getElementById('room_latitude').value;
    var room_longitude = document.getElementById('room_longitude').value;

    var seeker_longitude = document.getElementById('seeker_longitude').value;
    var seeker_latitude = document.getElementById('seeker_latitude').value;

    var user_city = [city_longitude, city_latitude];
    var room_place = [room_longitude, room_latitude];
    var seeker_place = [seeker_longitude, seeker_latitude];

    mapboxgl.accessToken = 'pk.eyJ1IjoiZXhwb3VuZGVyMTIzIiwiYSI6ImNrODJwY3hjeTEzZW0zZm5xeHJxZHQxd3gifQ.7MCsao35-JomeQ69Yg0ecQ';
    var map = new mapboxgl.Map({
        container: 'map'
        , style: 'mapbox://styles/mapbox/streets-v11', //v9
        center: user_city
        , zoom: 10
    });

    map.on('load', function() {
        addMarker(room_place, 'load');
        addMarker2(seeker_place, 'load');

    });

    // create the popup
    let markerPopup = new mapboxgl.Popup({
            offset: 25
        })
        .setHTML(" Property location ");

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
            .setLngLat(seeker_place)
            .setPopup(markerPopup2) // sets a popup on this marker
            .addTo(map);
    }

    //rating
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var property_id = $('#property_id').val()
    var auth_id = $('#auth_id').val()
    var title = $('#title').val()
    var rating = 0;
    $('#rating').change(function() {
        rating = $("#rating option:selected").val();
        $.ajax({
            url: "{{route('add_rating')}}"
            , type: 'POST'
            , data: {
                user_id: auth_id
                , rating: rating
                , property_id: property_id
                , title: title
            }
        , })
    });

</script>
<script>
</script>

@endsection
