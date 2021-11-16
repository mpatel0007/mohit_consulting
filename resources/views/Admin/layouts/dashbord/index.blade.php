<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/theme/front_end/img/faveicon.png') }}"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/theme/css/bootstrap.min.css') }}">
    <!-- Typography CSS -->
    <link rel="stylesheet" href="{{ asset('assets/theme/css/typography.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/theme/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/theme/css/style.css') }}">
    <!-- Responsive CSS -->
    @yield('headersection')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript"> 
        var BASE_URL = "{{ url('/') }}"; 
        var ADMIN = "{{ADMIN}}";
    </script>
</head>

<body style="background: #f2f6fb">
    <!-- loader Start -->
    <div id="loading">
    <!-- <image src="http://localhost:8000/assets/theme/images/loader.gif" style="position:relative;top:50%;left:50%"> -->
    <image src="{{ asset('assets/theme/images/loader.gif') }}" style="position:relative;top:50%;left:50%">

    </div>
    <title>@yield('admindashboardtitle')</title>

    <!-- Wrapper Start -->
    <div class="wrapper">
        @include('Admin.layouts.dashbord.sidebar')
        @include('Admin.layouts.dashbord.header')
        <div id="content-page" class="content-page">
            @yield('admincontent')
        </div>
    </div>

    @include('Admin.layouts.dashbord.footer')
    <script src="{{ asset('assets/theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/bootstrap.min.js') }}"></script>
    <!-- Appear JavaScript -->
    <script src="{{ asset('assets/theme/js/jquery.appear.js') }}"></script>
    <!-- Countdown JavaScript -->
    <script src="{{ asset('assets/theme/js/countdown.min.js') }}"></script>
    <!-- Counterup JavaScript -->
    <script src="{{ asset('assets/theme/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/theme/js/jquery.counterup.min.js') }}"></script>
    <!-- Wow JavaScript -->
    <script src="{{ asset('assets/theme/js/wow.min.js') }}"></script>
    <!-- Apexcharts JavaScript -->
    <script src="{{ asset('assets/theme/js/apexcharts.js') }}"></script>
    <!-- Slick JavaScript -->
    <script src="{{ asset('assets/theme/js/slick.min.js') }}"></script>
    <!-- Select2 JavaScript -->
    <script src="{{ asset('assets/theme/js/select2.min.js') }}"></script>
    <!-- Owl Carousel JavaScript -->
    <script src="{{ asset('assets/theme/js/owl.carousel.min.js') }}"></script>
    <!-- Magnific Popup JavaScript -->
    <script src="{{ asset('assets/theme/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Smooth Scrollbar JavaScript -->
    <script src="{{ asset('assets/theme/js/smooth-scrollbar.js') }}"></script>
    <!-- lottie JavaScript -->
    <script src="{{ asset('assets/theme/js/lottie.js') }}"></script>
    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('assets/theme/js/chart-custom.js') }}"></script>
    <!-- Custom JavaScript -->
    <script src="{{ asset('assets/theme/js/custom.js') }}"></script>
    <!-- <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script> -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>


    <!-- <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> -->

    @yield('footersection')
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
</body>
</html>
