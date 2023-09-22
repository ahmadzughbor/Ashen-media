  <!-- ======= testimonials Section ======= -->
  <section id="clients" class="clients">
      <div class="container" data-aos="fade-up">
          <div class="row d-flex justify-content-center">
              <div class="col-lg-8">
                  <div class="section-title text-center">
                      <h2>Our partners</h2>
                  </div>
              </div>
          </div>
          <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
              <div class="swiper-wrapper">
                @foreach($partners as $item)
                  <div class="swiper-slide">
                      <img src="{{asset('storage/images/' . $item->path) }}" width="216" height="162" alt>
                  </div>
                  @endforeach
                 
              </div>
              <div class="swiper-pagination"></div>

          </div>
      </div>
  </section>
  <!-- End testimonials Section -->