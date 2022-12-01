<script src="{{ asset('js/pages1.js') }}" defer> </script>

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h1 style="font-weight: bold;">Create Auction Page</h1>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

<section id="portfolio-details" class="portfolio-details" style="margin-bottom: 40px">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;font-size:larger; ">
        <div class="portfolio-info bidFormBox">
        <h3>Fill in the details to create your auction</h3>  
          <form action="/auctionCreate" method="POST" id="auctionForm" class="profile" enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="form-group">
              <div class="form-floating mb-3">
                <input id="title" type="text" name="title"  class="form-control" required="required" minlength="3" maxlength="40">
                <label for="title">Title</label>
              </div>            

              <div class="form-floating mb-3">
                <textarea id="descriptions" name="description"  class = "form-control" required="required" minlength="10" maxlength="250" rows="4" cols="50" style="height:200px;"> </textarea>
                <label for="descriptions">Description</label>
              </div> 

              <div class="form-floating mb-3">
                <input id="carName" type="text" name="carName"  class = "form-control" required="required" minlength="3" maxlength="40">
                <label for="carName">Car Name</label>
              </div>
              
              
              <label for="categorie">Choose a categorie:</label>
              <select name="categorie" class="form-select" id="categorie" required>
              <option value="" selected>Please Select</option>
                <option value="Sport">Sport</option>
                <option value="Coupe">Coupe</option>
                <option value="Convertible">Convertible</option>
                <option value="SUV">SUV</option>
                <option value="Pickup Truck">Pickup Truck</option>
              </select>
                <br>
              <label for="state">Choose the state of the car:</label>
              <select name="state" class="form-select" id="state" required>
              <option value="" selected>Please Select</option>
                <option value="Wreck">Wreck</option>
                <option value="Poor Condition">Poor Condition</option>
                <option value="Normal Condition">Normal Condition</option>
                <option value="High Condition">High Condition</option>
                <option value="Brand New">Brand New</option>
              </select>
              <br>

              <div class="form-floating mb-3">
                <input id="color" type="text" name="color"  class = "form-control" required="required" minlength="3" maxlength="10">
                <label for="color">Car color:</label>
              </div>

              <div class="form-floating mb-3">
                <input id="consumption" type="text" name="consumption"  class = "form-control" required="required" minlength="1" maxlength="6" onkeypress="return checkConsumption(event)">
                <label for="consumption">Car consumption (in Liter/100km)</label>
              </div>

              <div class="form-floating mb-3">
                <input id="kilometers" type="text" name="kilometers"  class = "form-control" required="required" minlength="1" maxlength="5" onkeypress="return checkNumber(event)">
                <label for="kilometers">Car Mileage: (in km)</label>
              </div>
              </div>
              <label for="file">Upload car photo</label>
              <input type="file" id="imageInput" name="image" class="form-control" required="required"><br><br>

              <label for="priceStart">Starting Price</label>
              <div class="input-group mb-3">
              <input id="priceStart" type="text" name="priceStart"  class="form-control form-control-lg" required="required" onkeypress="return checkNumber(event)">
              <span class="input-group-text">€</span>
              
              </div>
              <label id="error"></label> <br> 

              <label for="timeClose">Pick the closing date</label>
              <div class="input-group date" data-provide="datepicker">              
              <input type="date" class="form-control" id="timeClose" name="timeClose" value="" min="" max=""> <br> <br>
              </div>

            
            <input type="hidden" name="user" value="{{ Auth::user()->id }}">

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" onclick="return !!(checkCarValue() & verifyFileUpload(event))" >Create</button>

            <p id="error_messages" style="color: black">
              <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
            </p>
          </form>
          </div>
      </div>
    </div>
  </div>  
</section>             


<body onload="auctionDateRange()"> </body>