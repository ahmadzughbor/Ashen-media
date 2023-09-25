<header id="header" class="fixed-top bg-header-portfolio">
  <div class="container d-flex align-items-center justify-content-between">

    <a href="index.html" class="logo"><img src="{{asset('storage/images/' . $settings->app_logo) }}" width="107" height="40" alt class="img-fluid"></a>

    <nav id="navbar" class="navbar order-lg-1 order-2">
      <ul>
        <li><a class="nav-link scrollto active" href="#hero">{{__('Home')}}</a></li>
        <li><a class="nav-link scrollto" href="#about">{{__('AboutUs')}} </a></li>
        <li><a class="nav-link scrollto" href="#services">{{__('Services')}}</a></li>
        <li><a class="nav-link scrollto " href="#pricing">{{__('Packages')}}</a></li>
        <li><a class="nav-link scrollto " href="#testimonials">{{__('Clients')}}</a></li>
        <li><a class="nav-link scrollto" href="#contact">{{__('ContactUs')}}</a></li>
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>

    </nav><!-- .navbar -->
    <div class="social d-flex align-items-center order-lg-2 order-1">
      @if(app()->getLocale() == 'ar')
      <a class="getstarted" href="{{ route('frontend.index', ['locale' => 'en']) }}"> English <img src="{{ $assets }}/assets/img/ps.png" height="12" alt></a>
      @else
      <a class="getstarted" href="{{ route('frontend.index', ['locale' => 'ar']) }}"> العربية <img src="{{ $assets }}/assets/img/ps.png" height="12" alt></a>
      @endif
    </div>
    
  </div>
</header>