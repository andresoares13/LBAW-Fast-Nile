<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Edit Auction Information</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->




<script src="{{ asset('js/pages1.js') }}" defer> </script>
<p hidden id="lTitle"><?php echo $auction->title?></p>


<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Update your Auction</h3>
          <form action="/auctionEdit" method="POST" id="auctionForm" class="profile" enctype="multipart/form-data">
          <caption>Edit auction title and description <br> <br></caption>
            {{ csrf_field() }}
            <div class="form-group">
              <div class="form-floating mb-3">
                <input id="title" type="text" name="title"  class="form-control" required="required" minlength="3" maxlength="40"> 
                <label for="title">Title</label>
              </div>
              <div class="form-floating mb-3">  
                <textarea id="description" name="description" class="form-control" required="required" minlength="10" maxlength="250" rows="4" cols="50" style="height:200px;">{{$auction->descriptions}}</textarea>
                <label for="description">Description</label>
              </div>

              <label for="file">Change car photo</label>
              <input type="file" id="imageInput" name="image" class="form-control" ><br><br>
            </div>  
            
            
            

            <input type="hidden" name="auction" value="{{ $auction->id }}">

            <label id="error"></label> <br> 

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit"  onclick="return verifyFileUpload(event)">Save</button>

          </form>

<script type="text/javascript">
let title = document.getElementById('lTitle').innerHTML
document.getElementById('title').value = title;
</script>

