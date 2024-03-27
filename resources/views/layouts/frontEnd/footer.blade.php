<footer id="footer">

          <div class="container">
            <div class="row align-items-center">
              <div
                class="col-md-4 d-flex justify-content-md-start justify-content-center mt-md-0 mt-2">
                <img src="{{asset('storage/images/' . $settings->app_logo) }}" width="107" height="40" alt>
              </div>
              <div class="col-md-4">
                <div class="copyright text-center">
                  All Rights Reserved <strong><a target="_blank"
                      href="@isset($settings){{ $settings->instagramLink}} @endisset">ashenmedia</a>
                    2023</strong> ©
                </div>
              </div>
              <div
                class="col-md-4 d-flex justify-content-md-end justify-content-center mt-md-0 mt-2">
                <div class="social-links">
                  <a target="_blank" href="@isset($settings){{ $settings->facebookLink}} @endisset" class="facebook"><i
                      class="bx bxl-facebook"></i></a>
                  <a target="_blank" href="@isset($settings){{ $settings->twitterLink}} @endisset" class="twitter"><i
                      class="bx bxl-twitter"></i></a>
                  <a target="_blank"
                    href="@isset($settings){{ $settings->instagramLink}} @endisset"
                    class="instagram"><i class="bx bxl-instagram"></i></a>
                  <a target="_blank" href="@isset($settings){{ $settings->snapchatLink}} @endisset" class="instagram"><i
                      class="bx bxl-snapchat"></i></a>
                  <a target="_blank" href="@isset($settings){{ $settings->tiktokLink}} @endisset" class="instagram"><i
                      class="bx bxl-tiktok"></i></a>
                </div>
              </div>

            </div>

          </div>

        </footer>