<script src="{{ asset('js/pages.js') }}" defer> </script>

<form action="/auctionCreate" method="POST" id="auctionForm" class="profile" enctype="multipart/form-data">
<caption>Fill in the details to create your auction <br> <br></caption>
  {{ csrf_field() }}

  <label for="title">Title:</label>
  <input id="title" type="text" name="title"  class = "auctionC" required="required" minlength="3" maxlength="40">
 
  <label for="descriptions">Description:</label>
  <textarea id="descriptions" name="description"  class = "auctionC" required="required" minlength="10" maxlength="250" rows="4" cols="50"> </textarea>

  <label for="carName">Car name:</label>
  <input id="carName" type="text" name="carName"  class = "auctionC" required="required" minlength="3" maxlength="40">

  <label for="categorie">Choose a categorie:</label>
  <select name="categorie" id="categorie" required>
  <option value="" selected>Please Select</option>
    <option value="Sport">Sport</option>
    <option value="Coupe">Coupe</option>
    <option value="Convertible">Convertible</option>
    <option value="SUV">SUV</option>
    <option value="Pickup Truck">Pickup Truck</option>
  </select>
  <br>


  <label for="state">Choose the state of the car:</label>
  <select name="state" id="state" required>
  <option value="" selected>Please Select</option>
    <option value="Wreck">Wreck</option>
    <option value="Poor Condition">Poor Condition</option>
    <option value="Normal Condition">Normal Condition</option>
    <option value="High Condition">High Condition</option>
    <option value="Brand New">Brand New</option>
  </select>
  <br>

  <label for="color">Car color:</label>
  <input id="color" type="text" name="color"  class = "auctionC" required="required" minlength="3" maxlength="10">

  <script src="{{ asset('js/pages.js') }}"></script>

  <label for="consumption">Car consumption: (in Liter/100km)</label>
  <input id="consumption" type="text" name="consumption"  class = "auctionC" required="required" minlength="1" maxlength="6" onkeypress="return checkConsumption(event)">

  <label for="kilometers">Car Mileage: (in km)</label>
  <input id="kilometers" type="text" name="kilometers"  class = "auctionC" required="required" minlength="1" maxlength="5" onkeypress="return checkNumber(event)"><br><br>
 
  <label for="file">Upload car photo</label>
  <input type="file" name="image" required="required"><br><br>

  <label for="priceStart">Starting Price:</label>
  <input id="priceStart" type="text" name="priceStart"  class = "auctionC" required="required" onkeypress="return checkNumber(event)"><i> €<i>
  <label id="error"></label> <br> <br>

  <label for="timeClose">Pick the closing date:</label>
  <input type="date" id="timeClose" name="timeClose" value="" min="" max=""> <br> <br>

  <input type="hidden" name="user" value="{{ Auth::user()->id }}">

  <button type="submit" onclick="return checkCarValue()" >Create</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>


<body onload="auctionDateRange()"> </body>