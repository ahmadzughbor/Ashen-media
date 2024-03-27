<!DOCTYPE html>
<html 
@if(app()->getLocale() == 'ar')
 lang="ar" dir="rtl"
 @else
 lang="en" 
 @endif
 >

@php
$assets = asset('front');
@endphp

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Ashen | specialized in the production and marketing </title>
    <meta content="A company specialized in the production and marketing of digital products in the wide electronic space, with high standards of accuracy and quality, and in smart and effective ways wrapped in creativity to keep pace with the requirements of the market and customers in sound, image and writing.
  " name="description">
    <meta content="Identity design,Publications design,Voiceover,Launching and managing marketing campaigns,Motion graphics,Managing social media pages,Website design and programming," name="keywords">

    <link href="{{ $assets }}/assets/img/logo.svg" rel="icon">
    <link href="{{ $assets }}/assets/img/logo.svg" rel="apple-touch-icon">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400&display=swap" rel="stylesheet">

    <link href="{{ $assets }}/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
    <link href="{{ $assets }}/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ $assets }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ $assets }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ $assets }}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ $assets }}/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="{{ $assets }}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ $assets }}/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <!-- <link href="{{ $assets }}/assets/css/bootstrap-rtl.min.css" rel="stylesheet"> -->
    @if(app()->getLocale() == 'ar')
    <link href="{{ $assets }}/assets/css/style.rtl.css" rel="stylesheet">
    @endif

    <link href="{{ $assets }}/assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>



<body>


    @include('layouts.frontEnd.navbar')


        @yield('content')

    @include('layouts.frontEnd.footer')


    <div id="preloader"></div>

    <a href="https://wa.me/+971502143112" target="_blank" class="whats-icon"><i class="bx bxl-whatsapp"></i></a>

    <script src="{{ $assets }}/assets/vendor/purecounter/purecounter.js"></script>
    <script src="{{ $assets }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ $assets }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ $assets }}/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ $assets }}/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ $assets }}/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <script src="{{ $assets }}/assets/js/main.js"></script>

</body>

</html>