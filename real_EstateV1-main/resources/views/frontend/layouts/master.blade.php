<!DOCTYPE html>
<html lang="en">
@include('frontend.layouts.head')
<body>
    <div class="box-collapse">
        <div class="title-box-">
            <h3 class="title-d">Search Property</h3>
        </div>
        <span class="close-box-collapse right-boxed bi bi-x"></span>
        <div class="box-collapse-wrap form">
            <form class="form-a" action="{{ route('search_Property') }}" enctype="multipart/form-data" method="GET">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="form-group">
                            <label class="pb-2" for="keyword">Keyword</label>
                            <input type="text" name="keyword" class="form-control form-control-lg form-control-a" placeholder="Keyword">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-b">Search Property</button>
                    </div>
                </div>
            </form>
        </div>
    </div><!-- End Property Search Section -->>

    @include('frontend.layouts.navbar')

    @yield('content')
    @include('frontend.layouts.footer')

    {{-- <div id="preloader"></div> --}}
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    @include('frontend.layouts.scripts')

</body>

</html>
