<!-- ======= Services Section ======= -->
<section id="services" class="services">
    <div class="container" data-aos="fade-up">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h2>{{__('OurServices')}}</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                @foreach($services as $item )
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon-box">
                            <div class="icon"><img src="{{ $assets }}/assets/img/services/01.svg" alt></div>
                            <h4>{{ $item->title }}</h4>
                            <p>
                            {{ $item->description }}
                            </p>
                        </div>
                    </div>
                @endforeach
                <!-- <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon-box">
                        <div class="icon"><img src="{{ $assets }}/assets/img/services/02.svg" alt></div>
                        <h4>Managing social media pages</h4>
                        <p>
                            A specialized team undertakes the full management of social
                            media pages, taking into account the harmony between content
                            and designs, as well as the appropriate times for
                            publication, and certainly the target group.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><img src="{{ $assets }}/assets/img/services/03.svg" alt></div>
                        <h4>Motion graphics </h4>
                        <p>
                            From the time of choosing the idea until writing the script
                            to the accurate montage that connects the ideas to produce a
                            creative artistic product.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box">
                        <div class="icon"><img src="{{ $assets }}/assets/img/services/04.svg" alt></div>
                        <h4>Voiceover</h4>
                        <p>
                            We carefully select distinctive sounds and tone for you to
                            suit all vocal works.</p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="icon-box">
                        <div class="icon"><img src="{{ $assets }}/assets/img/services/05.svg" alt></div>
                        <h4>Identity design </h4>
                        <p>
                            We produce an integrated visual identity for you that
                            matches the idea of ​​the project and expresses it.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><img src="{{ $assets }}/assets/img/services/06.svg" alt></div>
                        <h4>Publications design</h4>
                        <p>Designing all kinds of prints with distinctive ideas, in
                            which we take into account simplicity and choose attractive
                            colors for them with a mixture of elegance in shape,
                            creativity and choice of colors.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4" data-aos="zoom-in" data-aos-delay="300">
                    <div class="icon-box">
                        <div class="icon"><img src="{{ $assets }}/assets/img/services/07.svg" alt></div>
                        <h4>Launching and managing marketing campaigns</h4>
                        <p>We produce an integrated visual identity for you that
                            matches the idea of ​​the project and expresses it. </p>
                    </div>
                </div> -->

            </div>

        </div>
</section><!-- End Services Section -->