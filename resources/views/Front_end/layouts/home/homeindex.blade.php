<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Bootstrap, Landing page, Template, Registration, Landing">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="author" content="Grayrids">
    <link rel="icon" type="image/png" href="{{ asset('assets/theme/front_end/img/faveicon.png') }}"/>
    <title>@yield('pagetitle')</title>
    <title>Home</title>
    <style>
        .select2-selection{
            overflow-y: auto !important;
        }
    </style>

    {{-- ___________________home start__________________________________________________ --}}
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/front_end/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/theme/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front_end/css/homestyle.css') }}">
    {{-- __________________home end _________________________ --}}

    {{-- __________________index start _________________________ --}}
    <link rel="stylesheet" href="{{ asset('assets/front_end/css/style.css') }}">    
    <link rel="stylesheet" href="{{ asset('assets/front_end/css/Formtabs.css') }}">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="stylesheet" href="{{ asset('assets/theme/css/fontawesome.css') }}">
        {{-- __________________index end _________________________ --}}

    {{-- ___________________home start__________________________________________________ --}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
        var BASE_URL = "{{ url('/') }}";
    </script>
    {{-- __________________home end _________________________ --}}
    {{-- __________________index start _________________________ --}}

      {{-- __________________index end _________________________ --}}
        <header id="home" class="hero-area">
                @include('Front_end.layouts.home.header')
                <?php  if(Request::path() ==  'home' || Request::path() ==  '/' ){ ?>
                        @include('Front_end.layouts.home.home_page.find_page')
                <?php } ?>
        </header>
</head>

<body>
    <div id="loader" class=""></div>
    <?php if(Request::path() !=  'home' && Request::path() !=  '/' ){ ?>
                @include('Front_end.layouts.home.home_page.page_header') 
    <?php } ?>
    @yield('headersection')
    @yield('content')
    {{-- ___________________home start__________________________________________________ --}}
    <?php  
         if(Request::path() ==  'home' || Request::path() ==  '/'){ ?>
                {{-- @include('Front_end.layouts.home.home_page.find_page') --}}
                @include('Front_end.layouts.home.home_page.categories')
                @include('Front_end.layouts.home.home_page.featured_jobs')
                @include('Front_end.layouts.home.home_page.browse_jobs')
                @include('Front_end.layouts.home.home_page.how_it_works')
                @include('Front_end.layouts.home.home_page.latest_jobs')
                @include('Front_end.layouts.home.home_page.clients_review')
                @include('Front_end.layouts.home.home_page.subscription_plan')
                @include('Front_end.layouts.home.home_page.blog_post')
                @include('Front_end.layouts.home.home_page.download_app_ad')
    <?php        
        }
    ?>
</body>
    {{-- @yield('footersection') --}}
    <footer>
    {{-- __________________home end _________________________ --}}


      {{-- __________________index start _________________________ --}}
        @yield('footersection')
        @include('Front_end.layouts.home.footer')
        <script src="//www.google.com/recaptcha/api.js"></script>
        <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
        <!-- Select2 JavaScript -->
        <script src="{{ asset('assets/theme/js/select2.min.js') }}"></script>
        <script>
            function logout() {
                Swal.fire({
                    icon: 'info',
                    title : 'Do you really want to logout?',
                    showCancelButton: true,
                    preConfirm: (login) => {
                            document.getElementById("logout-form").submit()
                    }
                });
            }   
        </script>
    </footer>
      {{-- __________________index end _________________________ --}}
</html>