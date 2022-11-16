<form action="{{ url('/profile/edit')}}" method="post" class="profile">

  <label for="name">Name:</label>
  <input id="name" type="text" name="name" value="<?=$user->names?>"  class = "profilein" required="required">
  
  <label for="address">Address:</label>
  <input id="address" type="text" name="address" value="<?=$user->address?>" class = "profilein" required="required">

  <label for="phone">Phone Number:</label>
  <input id="phone" type="text" name="phone" value="<?=$user->phone?>" class = "profilein" required="required">
  
  <button type="submit" class="delaccount" >Save</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>