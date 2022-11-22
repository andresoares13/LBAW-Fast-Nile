<form action="/upgrade" method="POST" id="upgradeForm" class="profile">

  {{ csrf_field() }}


  <label for="phone">To become an auctioneer, please enter your phone number. <br> <br></label>
  <script src="{{ asset('js/pages1.js') }}"></script>
  <input id="phone" type="text" name="phone" class = "profilein" onkeypress="return checkNumber(event)" required="required" minlength="5" maxlength="15">

  
  <input type="hidden" name="user" value="{{ Auth::user()->id }}">

  <button type="submit" >Upgrade</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>