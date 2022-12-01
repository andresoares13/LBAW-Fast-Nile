
<section id="shadow">
    <div class="shadow-container">
      <div id="topAuctionCarousel" data-bs-interval="5000" class="carousel slide" data-bs-ride="true">
      <ol class="carousel-indicators">
        <li data-bs-target="#topAuctionCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"> </li>
        <li data-bs-target="#topAuctionCarousel" data-bs-slide-to="1" aria-label="Slide 2"> </li>
        <li data-bs-target="#topAuctionCarousel" data-bs-slide-to="2" aria-label="Slide 3"></li>
      </ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide 1 -->
          <div class="carousel-item active" style="background-image: url({{asset('img/backgrounds/b1.jpg')}});">
            <div class="carousel-container">
            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start animate__animated animate__fadeInDown" style="background: url() center center no-repeat;"><img src="{{asset('img/car/' . $auctions[0]->getCarPicture($auctions[0]->idcar))}}" alt=""></div>
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">{{$auctions[0]->title}}</h2>
                <h2 class="animate__animated animate__fadeInUp">Top bid: {{$auctions[0]->pricenow}} €</h2>
                <div>
                  <a href="{{url('/auction/'.$auctions[0]->id)}}" class="btn-get-started animate__animated animate__fadeInUp scrollto">View Auction</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item" style="background-image: url({{asset('img/backgrounds/b2.jpg')}});">
            <div class="carousel-container">
            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start animate__animated animate__fadeInDown" style="background: url() center center no-repeat;"><img src="{{asset('img/car/' . $auctions[1]->getCarPicture($auctions[1]->idcar))}}" alt=""></div>  
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">{{$auctions[1]->title}}</h2>
                <h2 class="animate__animated animate__fadeInUp">Top bid: {{$auctions[1]->pricenow}} €</h2>
                <div>
                  <a href="{{url('/auction/'.$auctions[1]->id)}}" class="btn-get-started animate__animated animate__fadeInUp scrollto">View Auction</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div class="carousel-item" style="background-image: url({{asset('img/backgrounds/b3.jpg')}});">
            <div class="carousel-container">
            <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start animate__animated animate__fadeInDown" style="background: url() center center no-repeat;"><img src="{{asset('img/car/' . $auctions[2]->getCarPicture($auctions[2]->idcar))}}" alt=""></div>
              <div class="carousel-content">
                <h2 class="animate__animated animate__fadeInDown">{{$auctions[2]->title}}</h2>
                <h2 class="animate__animated animate__fadeInUp">Top bid: {{$auctions[2]->pricenow}} €</h2>
                <div>
                  <a href="{{url('/auction/'.$auctions[2]->id)}}" class="btn-get-started animate__animated animate__fadeInUp scrollto">View Auction</a>
                </div>
              </div>
            </div>
          </div>

        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#topAuctionCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#topAuctionCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>

      </div>
    </div>
  </section>


    <section id="faq" class="faq section-bg">
      <div class="container">

        <div class="section-title">
          <h2>Frequently Asked Questions</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="faq-list">
          <ul>
            <li data-aos="fade-up">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                <p>
                  Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="100">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                <p>
                  Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="200">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                <p>
                  Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="300">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                <p>
                  Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.
                </p>
              </div>
            </li>

            <li data-aos="fade-up" data-aos-delay="400">
              <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#faq-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
              <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                <p>
                  Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
                </p>
              </div>
            </li>

          </ul>
        </div>

      </div>
    </section><!-- End Frequently Asked Questions Section -->



