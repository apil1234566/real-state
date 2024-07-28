 <!-- ======= Header/Navbar ======= -->
 <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
     <div class="container">
         <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
             <span></span>
             <span></span>
             <span></span>
         </button>
         <a class="navbar-brand text-brand" href="{{url('/')}}">Real<span class="color-b"> State</span></a>

         <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
             <ul class="navbar-nav">

               <li class="nav-item{{ Route::is('/') ? ' active' : '' }}">
                   <a class="nav-link" href="{{ route('/') }}">Home</a>
               </li>

               <li class="nav-item{{ Route::is('agents') ? ' active' : '' }}">
                   <a class="nav-link" href="{{ route('agents') }}">Agents</a>
               </li>

               <li class="nav-item{{ Route::is('properties') ? ' active' : '' }}">
                   <a class="nav-link" href="{{ route('properties') }}">Property</a>
               </li>
                 @auth
                 @if(auth()->user()->role==2)
                 <li class="nav-item {{ Route::is('recommendation') ? ' active' : ''}}">
                     <a href="{{ route('recommendation') }}" class="nav-link">Recomendation</a>

                 </li>
                 @endif

                 <li class="nav-item {{ Route::is('home') ? ' active' : ''}}">
                     <a href="{{ url('/home') }}" class="nav-link">Dashboard</a>
                 </li>
                                
                 @else
                 <li class="nav-item {{ Route::is('login') ? ' active' : ''}}">
                     <a href="{{ route('login') }}" class="nav-link ">Login</a>
                 </li>

                 @if (Route::has('register'))
                 <li class="nav-item {{ Route::is('login') ? ' active' : ''}}">
                     <a href="{{ route('register') }}" class="nav-link ">Register</a>
                 </li>
                 @endif
                 @endauth

             </ul>
         </div>

         <button type="button" class="btn btn-b-n navbar-toggle-box navbar-toggle-box-collapse" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01">
             <i class="bi bi-search"></i>
         </button>

     </div>
 </nav><!-- End Header/Navbar -->
