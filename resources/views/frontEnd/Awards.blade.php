<!-- ======= Awards Section ======= -->
<section id="testimonials" class="testimonials">
    <div class="container" data-aos="fade-up">

        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h2>{{__('says')}}</h2>
                </div>
            </div>
        </div>

        <div class="awards-slider swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">

                <!-- Start item -->
                @foreach($says as $say )
                <div class="swiper-slide">
                    <div class="testimonial-wrap ">
                        <div class="testimonials-item">
                            <div class="d-flex mb-3">
                                <img src="{{asset('storage/images/' . $say->path) }}" width="80" height="80" alt>
                                <div class="px-3">
                                    <h3>{{ $say->user_name}}</h3>
                                    <span>{{ $say->company_name}}</span>
                                    <p>
                                        {{ $say->description}}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- End item -->
                @endforeach


            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>
</section><!-- End Awards Section -->