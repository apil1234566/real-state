<!-- Sidebar  -->
<nav id="sidebar" style="background:#343a40;">
    <div class="sidebar-header p-0 m-0">
        <a href="{{route('/')}}"><img src="{{ asset('backend/assets/img/logo.jpg') }}" alt="Logo" height="45px" width="45px"

                class="side_profile" /></a>
        <div class="row pl-5">
            <h6 class="float-left m-0 text-info side_profile">Welcome <i>{{Auth::user()->name}} </i></h6>
        </div>

    </div>
    <ul class="list-unstyled components">
        {{----------------------------------------------- start of ROOM OWNER ----------------------------------------------}}
        @if(auth()->user()->role == 1)
        {{-- <li class="dr">
            <a href="#sidebar_dashboard" data-toggle="collapse" aria-expanded="false" data-parent="#sidebar"
                class="dropdown-toggle">
                <i class="fas fa-home"></i>
                <b>Dashboard</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_dashboard">
                <li>
                    <a href="{{route('owner.dashboard')}}">Property Dashboard</a>
                </li>
            </ul>
        </li> --}}

        <li class="dr">
            <a href="#sidebar_accounting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-address-book"></i>
                <b>Profile</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_accounting">
                <li>
                    <a href="{{route('owner_profile',auth()->user()->name)}}">My Profile</a>
                </li>
            </ul>
        </li>
        <li class="dr">
            <a href="#sidebar_routine" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-calendar-week"></i>
                <b>Property Facilities</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_routine">
                <li>
                    <a href="{{route('room_facility.index')}}">All Property Facilities</a>
                </li>
            </ul>
        </li>

        <li class="dr">
            <a href="#sidebar_class" data-toggle="collapse" aria-expanded="false" data-parent="#sidebar"
                class="dropdown-toggle">
                <i class="fas fa-person-booth"></i>
                <b>Property</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_class">
                <li>
                    <a href="{{route('property.index')}}">All Property</a>
                </li>
                <li>
                    <a href="{{route('property.create')}}">Add Property</a>
                </li>
            </ul>
        </li>

        <li class="dr">
            <a href="#sidebar_notices" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-bell"></i>
                <b>Notices</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_notices">
                <li>
                    <a href="{{route('notice.index')}}">All Notices</a>
                </li>
                <li>
                    <a href="{{route('notice.create')}}">Add Notices</a>
                </li>
            </ul>
        </li>

        <li class="dr">
            <a href="#sidebar_feedback" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-users"></i>
                <b>Testimonials</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_feedback">
                <li>
                    <a href="{{route('testimonial.index')}}">My Testimonials</a>
                </li>

                <li>
                    <a href="{{route('testimonial.create')}}">Create Testimonial</a>
                </li>
            </ul>
        </li>

        {{-- <li class="dr">
            <a href="#sidebar_report" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-exclamation-circle"></i>
                <b>Request/Report</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_report">
                <li>
                    <a href="{{route('request_report.index')}}">All Request/Report</a>
                </li>

                <li>
                    <a href="{{route('request_report.create')}}">Create Request/Report</a>
                </li>
            </ul>
        </li> --}}

        <li class="dr">
            <a href="#sidebar_chat" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-comments"></i>
                <b>Chats</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_chat">
                <li>
                    <a href="{{route('all_friends')}}">My Friends</a>
                </li>
            </ul>
        </li>

        @endif
        @if(auth()->user()->role == 2)

        {{-- <li class="dr">
            <a href="#sidebar_dashboard" data-toggle="collapse" aria-expanded="false" data-parent="#sidebar"
                class="dropdown-toggle">
                <i class="fas fa-home"></i>
                <b>Dashboard</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_dashboard">
                <li>
                    <a href="{{route('seeker.dashboard')}}">User Dashboard</a>
                </li>
            </ul>
        </li> --}}

        <li class="dr">
            <a href="#sidebar_accounting" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-address-book"></i>
                <b>Profile</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_accounting">
                <li>
                    <a href="{{route('seeker_profile',auth()->user()->name)}}">My Profile</a>
                </li>
            </ul>
        </li>

        <li class="dr">
            <a href="#sidebar_library" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-person-booth"></i>
                <b>All Properties</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_library">
                <li>
                    <a href="{{route('seeker_room')}}">All Properties</a>
                </li>
                <li>
                    <a href="{{route('my_property')}}">My Properties</a>
                </li>

                {{-- <li>
                    <a href="{{route('my_bookmarks')}}">Bookmarks</a>
                </li> --}}
            </ul>
        </li>

        {{-- <li class="dr">
            <a href="#sidebar_feedback" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-comments"></i>
                <b>Recommendation</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_feedback">
                <li>
                    <a href="{{ route('recommendationMatrix') }}">Your Recommendation</a>
                </li>
            </ul>
        </li> --}}

        <li class="dr">
            <a href="#sidebar_users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-users"></i>
                <b>Testimonials</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_users">
                <li>
                    <a href="{{route('testimonial.index')}}">My Testimonials</a>
                </li>

                <li>
                    <a href="{{route('testimonial.create')}}">Create Testimonial</a>
                </li>
            </ul>
        </li>

        {{-- <li class="dr">
            <a href="#sidebar_report" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-exclamation-circle"></i>
                <b>Request/Report</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_report">
                <li>
                    <a href="{{route('request_report.index')}}">All Request/Report</a>
                </li>

                <li>
                    <a href="{{route('request_report.create')}}">Create Request/Report</a>
                </li>
            </ul>
        </li> --}}

        <li class="dr">
            <a href="#sidebar_chat" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-comments"></i>
                <b>Chats</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_chat">
                <li>
                    <a href="{{route('all_friends')}}">My Friends</a>
                </li>
            </ul>
        </li>
        @endif

      
        @if(auth()->user()->admin)

        <li class="dr">
            <a href="#sidebar_fee" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-universal-access"></i>
                <b>Users</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_fee">
                <li>
                    <a href="{{route('admin.all_users')}}">All Users</a>
                </li>
            </ul>
        </li>

        <li class="dr">
            <a href="#sidebar_exam" data-toggle="collapse" aria-expanded="false" data-parent="#sidebar"
                class="dropdown-toggle">
                <i class="fas fa-marker"></i>
                <b>Property Category</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_exam">
                <li>
                    <a href="{{route('room_category.index')}}">All Property  Categories</a>
                </li>
            </ul>
        </li>
        <li class="dr">
            <a href="#sidebar_routine" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-calendar-week"></i>
                <b>Property Facilities</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_routine">
                <li>
                    <a href="{{route('room_facility.index')}}">All Property Facilities</a>
                </li>
            </ul>
        </li>

        <li class="dr">
            <a href="#sidebar_notices" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-bell"></i>
                <b>Notices</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_notices">
                <li>
                    <a href="{{route('notice.index')}}">All Notices</a>
                </li>
                <li>
                    <a href="{{route('notice.create')}}">Add Notices</a>
                </li>
            </ul>
        </li>

        {{-- <li class="dr">
            <a href="#sidebar_report" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-exclamation-circle"></i>
                <b>Request/Report</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_report">
                <li>
                    <a href="{{route('request_report.index')}}">All Request/Report</a>
                </li>

                <li>
                    <a href="{{route('request_report.create')}}">Create Request/Report</a>
                </li>
            </ul>
        </li> --}}

        <li class="dr">
            <a href="#sidebar_users" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-users"></i>
                <b>Testimonials</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_users">
                <li>
                    <a href="{{route('testimonial.store')}}">All Testimonials</a>
                </li>
            </ul>
        </li>

        {{-- <li class="dr">
            <a href="#sidebar_task" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="fas fa-clock"></i>
                <b>Scheduling Task</b>
            </a>
            <ul class="drm collapse list-unstyled m-0" id="sidebar_task">
                <li>
                    <a href="{{route('tasks.index')}}">All Tasks</a>
                </li>
            </ul>
        </li> --}}
        @endif
        {{----------------------------------------------- end of ADMIN --------------------------------------------------}}



       
    </ul>
</nav>