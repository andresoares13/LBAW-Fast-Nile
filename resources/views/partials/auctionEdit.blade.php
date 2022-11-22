<script src="{{ asset('js/pages1.js') }}" defer> </script>
<p hidden id="lTitle"><?php echo $auction->title?></p>

<form action="/auctionEdit" method="POST" id="auctionForm" class="profile" enctype="multipart/form-data">
<caption>Edit auction title and description <br> <br></caption>
  {{ csrf_field() }}

  <label for="title">Title: </label>
  <input id="title" type="text" name="title"  class = "auctionC" required="required" minlength="3" maxlength="40"> 
  <label for="description">Description:</label>
  <textarea id="description" name="description" class = "auctionC" required="required" minlength="10" maxlength="250" rows="4" cols="50">{{$auction->descriptions}}</textarea>


  <input type="hidden" name="auction" value="{{ $auction->id }}">

  <button type="submit"  >Save</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>

<script type="text/javascript">
let title = document.getElementById('lTitle').innerHTML
document.getElementById('title').value = title;
</script>

