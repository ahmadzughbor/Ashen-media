<!-- ======= Projects Section ======= -->
<section id="projects" class="projects">
    <div class="container" data-aos="fade-up">
        <div class="row d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <h2> {{__('OurProjects')}}</h2>
                </div>
            </div>
            <div class="row justify-content-center">
                <?php $index = 1  ?>
                @foreach($projects as $item)
                <div class=" mt-3 @if($index == 3) col-md-12 iframe-3 @else col-md-6 @endif"  @if($index == 3) data-aos-delay="200" @elseif($index == 2)  data-aos-delay="150" @else data-aos-delay="100"  @endif data-aos="zoom-in">
                    <iframe src="{{$item->link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <?php $index += 1  ?>
                @endforeach
               

            </div>

        </div>
</section><!-- End Services Section -->