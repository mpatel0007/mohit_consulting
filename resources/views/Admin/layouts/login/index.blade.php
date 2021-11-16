<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>@yield('title')</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{asset('assets/theme/images/favicon.ico')}}">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{asset('assets/theme/css/bootstrap.min.css')}}">
        <!-- Typography CSS -->
        <link rel="stylesheet" href="{{asset('assets/theme/css/typography.css')}}">
        <!-- Style CSS -->
        <link rel="stylesheet" href="{{asset('assets/theme/css/style.css')}}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{asset('assets/theme/css/responsive.css')}}">
    
     </head>
<body>
    @yield('admincontent')
</body>
</html>