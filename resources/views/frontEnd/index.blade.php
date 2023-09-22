@extends('layouts.frontEnd.index')



@php
$assets = asset('front');
@endphp

@section('content')


    <!-- Start #main -->
    <main id="main">

        
        @include('frontEnd.slider')
        @include('frontEnd.about')
        @include('frontEnd.Services')
        @include('frontEnd.Projects')
        @include('frontEnd.Statistic')
        @include('frontEnd.pricing')
        @include('frontEnd.Awards')
        @include('frontEnd.partners')
        @include('frontEnd.Contactus')

        

    </main>
    <!-- End #main -->

@endsection
