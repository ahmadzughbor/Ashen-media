 <!-- ======= Hero Section ======= -->
 <section id="hero" class="hero d-flex align-items-center ">
     <div class="container">
         <div class="row">
             <div class="col-lg-6 d-flex flex-column justify-content-center order-lg-first order-last">
                 <h1 data-aos="fade-up" data-aos-delay="200">{{__('AboutUs')}} </h1>
                 <h2 data-aos="fade-up" data-aos-delay="250">
                     @if($aboutus)
                        @if(app()->getLocale() == 'ar')
                        {{$aboutus->description_ar}}
                        @else
                        {{$aboutus->description}}
                        @endif
                     @endif

                 </h2>
             </div>
             <div class="col-lg-6 hero-img  p-2 order-lg-last order-first" data-aos="zoom-out" data-aos-delay="100">
                 <img src=" @if($aboutus) {{asset('storage/images/' . $aboutus->path)}} @endif " width="579px" height="579px" class="img-fluid" alt>
             </div>
         </div>
     </div>

 </section><!-- End Hero -->


 <!-- ======= About Section ======= -->
 <div id="about" class="about">
     <div class="container">
         <section>
             <div class="row content d-flex align-items-center">
                 <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                     <img src="@if($ourvision){{asset('storage/images/' . $ourvision->path)}} @endif" class="img-fluid  p-3" alt="about image">
                 </div>
                 <div class="col-lg-6 pt-5 pt-lg-0 " data-aos="fade-up" data-aos-delay="100">
                     <h2 class="mb-3"> {{__('OurVision')}} </h2>
                     <p>
                         @if($ourvision)
                         @if(app()->getLocale() == 'ar')
                         {{$ourvision->description_ar}}
                         @else
                         {{$ourvision->description}}
                        @endif
                         @endif

                     </p>
                 </div>
             </div>
         </section>
         <!-- رسالتنا  -->
         <section>
             <div class="row content d-flex align-items-center ">
                 <div class="col-lg-6 order-lg-last order-first" data-aos="fade-up" data-aos-delay="100">
                     <img src="@if($ourmission){{asset('storage/images/' . $ourmission->path)}} @endif" class="img-fluid  p-2" alt="about image">
                 </div>
                 <div class="col-lg-6 pt-5 pt-lg-0  order-lg-first order-last" data-aos="fade-up" data-aos-delay="150">
                     <h2 class="mb-3">  {{__('OurMission')}}</h2>
                     <p>
                         @if($ourmission)
                            @if(app()->getLocale() == 'ar')
                            {{$ourmission->description_ar}}
                            @else
                            {{$ourmission->description}}
                            @endif
                         @endif

                     </p>
                 </div>
             </div>
         </section>

         <!-- اهدافنا  -->
         <section>
             <div class="row our-goal content d-flex align-items-center ">
                 <div class="col-lg-6 " data-aos="fade-up" data-aos-delay="200">
                     <img src="@if($ourgoals){{asset('storage/images/' . $ourgoals->path)}} @endif" class="img-fluid p-2" alt="about image">
                 </div>
                 <div class="col-lg-6 pt-5 pt-lg-0  " data-aos="fade-up" data-aos-delay="200">
                     <h2 class="mb-3">{{__('ourGoals')}}</h2>
                     <p>
                         @if($ourgoals)
                            @if(app()->getLocale() == 'ar')
                                {{$ourgoals->description_ar}}
                            @else
                                {{$ourgoals->description}}
                            @endif
                         @endif
                     </p>
                     <!-- <ul>
                         <li>Introducing new and innovative approaches to design,
                             preparation, production and content.</li>
                         <li>Meeting customer needs at the most appropriate prices
                             possible.</li>
                         <li>Providing customers with the best and most effective
                             marketing plans.</li>
                         <li>Increasing the target audience to include the local as
                             well as the Arab level.</li>
                         <li>Facilitating the provision of services to the customer, so
                             that our company includes most of the marketing services for
                             the production of digital products, starting with image,
                             sound and writing</li>
                     </ul> -->
                 </div>
             </div>
         </section>

     </div>
 </div><!-- End About Section -->