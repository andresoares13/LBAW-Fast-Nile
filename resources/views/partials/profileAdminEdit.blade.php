<form action="/editAdmin" method="POST" class="profile">

  {{ csrf_field() }}

  <label for="name">Name:</label>
  <input id="name" type="text" name="name" value="<?=$admin->names?>"  class = "profilein" required="required">
  

  
  <input type="hidden" name="admin" value="{{ Auth::guard('admin')->user()->id }}">

  <button type="submit" >Save</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>


