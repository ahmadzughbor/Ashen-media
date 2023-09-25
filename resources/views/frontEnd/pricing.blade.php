<!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing section-bg">

    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h2> {{__('Packages')}}</h2>
                </div>
            </div>
        </div>
        <div class="row gy-4" data-aos="fade-left">
            <?php $index = 1?>
            @foreach($packages as $package)
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="box @if($index == 3) featured @endif ">
                    <h3>{{$package->name}}</h3>
                    <div class="price"><sup>AED</sup>{{$package->amount}}<span> / Month</span></div>
                    <ul class="mt-4">
                        @foreach($package->features as $feature)
                        <li>
                            <p>{{$feature->name}}</p>
                            <p>{{$feature->value}}</p>
                        </li>
                        @endforeach
                    </ul>
                    <a href="@isset($settings){{ $settings->whatsappLink}} @endisset" class="btn-buy">selsct packages</a>
                </div>
            </div>
            <?php $index +=1 ?> 
            @endforeach

            

        </div>

    </div>

</section><!-- End Pricing Section -->