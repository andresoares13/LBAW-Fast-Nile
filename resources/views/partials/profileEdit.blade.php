<form action="/edit" method="POST" class="profile">

  {{ csrf_field() }}

  <label for="name">Name:</label>
  <input id="name" type="text" name="name" value="<?=$user->names?>"  class = "profilein" required="required">
  
  <label for="address">Address:</label>
  <input id="address" type="text" name="address" value="<?=$user->address?>" class = "profilein" required="required">

  <?php if (count($auctioneer) != 0) { ?>
  <label for="phone">Phone Number:</label>
  <input id="phone" type="text" name="phone" value="<?=$auctioneer[0]["phone"]?>" class = "profilein" required="required">
  <?php } ?>
  
  <input type="hidden" name="user" value="{{ Auth::user()->id }}">

  <button type="submit" >Save</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>