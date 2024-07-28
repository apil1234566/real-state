<div class="card-body mb-2">
    <h5 class="text-muted pb-2">
        <b><i class="fas fa-home"></i> Property Title</b>
        : {{$property->titlelimit}}
    </h5>

    <h5 class="text-muted pb-2">
        <b><i class="fas fa-globe-americas"></i> Location</b>
        : {{$property->place->name}}, {{$property->city->name}}, Nepal
    </h5>

    <h5 class="text-muted pb-2">
        <b><i class="fab fa-cuttlefish"></i> Property Category</b>
        : {{$property->category->name}}
    </h5>

    <h5 class="text-muted pb-2">
        <b><i class="fas fa-hand-holding-usd"></i> Price</b>
        : <i class="fas fa-rupee-sign"></i> {{$property->price}}
    </h5>

    <h5 class="text-muted pb-2">
        <b><i class="fas fa-street-view"></i> No of Rooms</b>
        : {{$property->total_rooms}}
    </h5>

    @auth
    <h5 class="text-muted pb-2">
        <b><i class="fas fa-user-astronaut"></i> Property Owner</b>
        : @if(auth()->user()->role == 2)
        <a href="{{route('owner.show',$property->owner->id)}}" class="btn btn-outline-info btn-sm"><i
                class="fas fa-external-link-alt"></i> {{$property->user->name}}</a>
        @else
        {{$property->user->name}}
        @endif
    </h5>
    @endauth

    <h5 class="text-muted pb-2">
        <b><i class="fas fa-user-lock"></i> Property Facilities</b>
    </h5>
    <h6>@foreach($property->facilities as $facility)
        <span class="badge badge-pill badge-success"> {{$facility->name}}</span>
        @endforeach
    </h6>

</div>