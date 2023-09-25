 <!-- ======= testimonials Section ======= -->
 <section id="contact" class="contact">
     <div class="container" data-aos="fade-up">
         <div class="row d-flex justify-content-center">
             <div class="col-lg-8">
                 <div class="section-title text-center">
                     <h2>{{__('ContactUs')}}</h2>
                 </div>
             </div>
         </div>

         <div class="container pb-5 pt-3">
             <div class="row mb-4 align-items-center flex-lg-row-reverse">
                 <div class="col-md-6 mb-4 mb-lg-0 " data-aos="fade-up" data-aos-delay="150">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3631.100919789713!2d54.34975139999999!3d24.4819599!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5e6764da00da03%3A0xd34212161cfd774a!2sAshen%20Media!5e0!3m2!1sar!2s!4v1694535701515!5m2!1sar!2s" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                 </div>
                 <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                     <div class="container py-4">

                         <form id="contactForm" action="{{route('ContactUs.store')}}" name="contactForm">
                             @csrf
                             <div class="row">
                                 <div class="col">
                                     <label class="mb-1">First Name</label>
                                     <input type="text" name="first_name" class="form-control" required placeholder="First Name" aria-label="First Name">
                                 </div>
                                 <div class="col">
                                     <label class="mb-1">Last Name</label>
                                     <input type="text" name="last_name" class="form-control" required placeholder="Last Name" aria-label="Last Name">
                                 </div>
                             </div>

                             <div class="col-12 mt-2">
                                 <label class="mb-1">Email</label>
                                 <input type="Email" name="Email" class="form-control" required id="email" placeholder="asem@gmail.com">
                             </div>
                             <div class="col-12 mt-2">
                                 <label class="mb-1">Phone</label>
                                 <input type="tel" name="Phone" class="form-control" required id="tel" placeholder="+000 000 000 000">
                             </div>
                             <div class="col-12 mt-2 mb-3">
                                 <label class="mb-1">Message</label>
                                 <textarea name="Message" class="form-control" required id="message" type="text" placeholder="Message" style="height: 8rem;" data-sb-validations="required"></textarea>
                                 <div class="invalid-feedback" data-sb-feedback="message:required">Message is
                                     required.</div>
                             </div>

                             <!-- Form submissions success message -->
                             <div class="d-none" id="submitSuccessMessage">
                                 <div class="text-center mb-3">Form submission
                                     successful!</div>
                             </div>

                             <!-- Form submissions error message -->
                             <div class="d-none" id="submitErrorMessage">
                                 <div class="text-center text-danger mb-3">Error
                                     sending message!</div>
                             </div>

                             <!-- Form submit button -->
                             <div class="d-grid">
                                 <button class="btn btn-primary btn-lg " id="saveBtn" type="submit">Send</button>
                             </div>

                         </form>

                     </div>

                 </div><!-- /col -->
             </div>
         </div>

     </div>
 </section>
 <!-- End testimonials Section -->


 <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

 <script>
     $(function() {

         /*------------------------------------------
          --------------------------------------------
          Pass Header Token
          --------------------------------------------
          --------------------------------------------*/
         $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });

         /*------------------------------------------
         --------------------------------------------
         Render DataTable
         --------------------------------------------
         --------------------------------------------*/
     });

     $(document).ready(function() {

         $('#saveBtn').click(function(e) {

             var form = $("#contactForm")[0];
             e.preventDefault();
             var data = new FormData(form)
             var url = $("#contactForm").attr('action');
             debugger;
             $.ajax({
                 data: data,
                 url: url,
                 type: "POST",
                 dataType: 'json',
                 contentType: false,
                 cache: false,
                 processData: false,
                 success: function(data) {

                     $('#serviceForm').trigger("reset");
                     $('#ajaxModel').modal('hide');
                     toastr.success('done');

                 },
                 error: function(data) {
                     console.log('Error:', data);
                     toastr.error(data);

                     $('#saveBtn').html('Save Changes');
                 }
             });
         });


     });
 </script>