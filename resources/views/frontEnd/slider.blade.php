<section class="cover pb-2">
    <div class="hero-slider swiper" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper-wrapper">

            <!-- Start item -->
            @foreach($sliders as $item)
            <div class="swiper-slide text-center">
                <img src="{{asset('storage/images/' . $item->path)}}" width="1280" height="550"  alt>
            </div>
            @endforeach

        </div>
        <div class="swiper-pagination"></div>

    </div>
</section>