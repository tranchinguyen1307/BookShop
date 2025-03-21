<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'MultiShop - Online Shop Website')</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="Free HTML Templates" name="keywords">
        <meta content="Free HTML Templates" name="description">
    
        <!-- Favicon -->
        <link href="{{ asset('client/img/favicon.ico') }}" rel="icon">
    
        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  
    
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    
        <!-- Libraries Stylesheet -->
        <link href="{{ asset('client/lib/animate/animate.min.css') }}" rel="stylesheet">
        <link href="{{ asset('client/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    
        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('client/css/style.css') }}" rel="stylesheet">
        @stack('style')
    </head>
    <body>
       <x-client.navbar/>
        @yield('content')
        <x-client.footer/>
    </body>
</html>