<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="{{asset('css/front.css')}}"> 
        <style>
            .main-panel{
                background-image: url('{{asset('media/arabesque-pattern-flat-style_23-2149201632-removebg-preview 1.svg')}}');
                background-repeat: no-repeat;
                background-size: cover;
                width: 100%;
                height: 100%;
            }
            .bg-grey{
                background-image: url('{{asset('media/Subtract1.svg')}}');
            }
        </style>
        @stack('styles')
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="container-fluid shadow-card">
            <nav class="container-fluid ps-4 pe-4 pt-2 pb-2">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-3 d-flex align-content-center me-3 p-2">
                        <a href="{{route('home')}}">
                            <img src="{{asset('media/Vector.svg')}}" alt="">
                        </a>
                        <h5 class="d-flex align-content-center me-3 mt-2 "> المرضي </h5>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-end">
                            <div class="tdnn">
                                <div class="moon"></div>
                            </div>
                           <div class="mt-3 ms-3 me-3" style="font-size: x-large;">
                                <i class="far fa-bell"></i>
                           </div>

                           <div class="dropdown">
                            <div class="me-3 cursor-pointer" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <a href="btn">
                                    <img src="{{ asset('media/profile picture of person in glasses and orange shirt.svg') }}" alt="Profile Picture" class="dropdown-toggle">
                                </a>
                            </div>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                @auth
                                    <div class="dropdown-item" style="border-bottom: 2px solid gray;">
                                        <!-- Display the student's name -->
                                        <span > {{ Auth::user()->name }} </span>
                                    </div>
                                    <a href="{{ route('student-profile') }}" class="dropdown-item">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="dropdown-item">Login</a>
                                    <a href="{{ route('register') }}" class="dropdown-item">Register</a>
                                @endauth
                            </div>
                        </div>
                        

                        </div>
                    </div>
                </div>
            </nav>
        </div>
        
        @yield('content')

        <footer>
            <div class="container-fluid shadow-card bg-dark bg-gradient">
                <div class="row ps-5 pe-5">
                    <div class="col-md-6">
                        <div class="row p-5">
                            <div class="col-md-3 border-left">
                                <h1> المرضي </h1>
                            </div>
                            <div class="col-md-8 me-2">
                                <h5 class="row">
                                    افضل منصة تعليمية للغة العربية
                                </h5>
                                <h5 class="row">
                                    جميع الحقوق محفوظة لEdulens Technology   
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row p-5">
                            <h5> تابعنا من خلال اللينكات </h5>
                        </div>
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-5 d-flex justify-content-between">
                                <i class="fab fa-tiktok"></i>
                                <i class="fab fa-youtube"></i>
                                <i class="fab fa-telegram"></i>
                                <i class="fab fa-instagram"></i>
                                <i class="fab fa-facebook-f"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        
        @livewireScripts
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
        @stack('scripts')
        <script>
            $(document).ready(function() {
                // Function to apply light mode classes
                function applyLightMode() {
                    $("body").addClass('light');
                    $(".moon").addClass('sun');
                    $(".tdnn").addClass('day');
                    $(".bg-dark").removeClass('bg-dark').addClass('bg-light');
                    $(".bg-black").removeClass('bg-black').addClass('bg-white');
                    $(".text-light").removeClass('text-light').addClass('text-dark');
                    
                }

                // Function to apply dark mode classes
                function applyDarkMode() {
                    $("body").removeClass('light');
                    $(".moon").removeClass('sun');
                    $(".tdnn").removeClass('day');
                    $(".bg-light").removeClass('bg-light').addClass('bg-dark');
                    $(".bg-white").removeClass('bg-white').addClass('bg-black');
                    $(".text-dark").removeClass('text-dark').addClass('text-light');
                }

                // Check the saved mode from localStorage and apply it
                if (localStorage.getItem('mode') === 'day') {
                    applyLightMode();
                }

                // Toggle mode on click and save the state in localStorage
                $('.tdnn').click(function () {
                    if ($('.tdnn').hasClass('day')) {
                        applyDarkMode();
                        localStorage.removeItem('mode');
                    } else {
                        applyLightMode();
                        localStorage.setItem('mode', 'day');
                    }
                });
            });
        </script>
    </body>
</html>
