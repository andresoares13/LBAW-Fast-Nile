<section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h1 style="font-weight: bold;">Edit Auction Status</h1>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->


@php
$ending = null;
if ($auction->ending){
    $ending = "is ending";
}
else{
    $ending = "is not ending";
}
@endphp

<script src="{{ asset('js/pages1.js') }}" defer> </script>



<section id="portfolio-details" class="portfolio-details" style="min-height: calc(100vh - 238px);">
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Change Auction Status - Ending</h3>
          <form action="/auctionStatus"  method="POST" id="auctionStatusEndingForm" class="profile" enctype="multipart/form-data">
          <caption>Current Status: {{$auction->states}} and {{$ending}}<br></caption>
            {{ csrf_field() }}
            <fieldset class="form-group">
            <div class="form-check form-switch">
            <legend class="mt-4">Set Ending</legend>
                @if (!$auction->ending)
                <input class="form-check-input" type="checkbox" name="ending" type="checkbox" value="false" onchange="toggleEnding()" id="flexSwitchCheckDefault">
                <label id="endingLabel"  class="form-check-label" for="flexSwitchCheckDefault">Not Ending</label>
                @else
                <input class="form-check-input" type="checkbox" name="ending" type="checkbox" value="true" onchange="toggleEnding()" id="flexSwitchCheckChecked" checked="">
                <label id="endingLabel" class="form-check-label" for="flexSwitchCheckChecked">Ending</label>
                @endif
            </div>
          
            </fieldset>  
            
            
            

            <input type="hidden" name="auction" value="{{ $auction->id }}">

            <label id="error"></label> <br> 

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Change</button>

          </form>
        </div>
      </div>

      <div class="col-lg-4" style="margin-left:auto;margin-right:auto;">
        <div class="portfolio-info bidFormBox" >
        <h3>Change Auction Status - Close</h3>
          <form action="/auctionStatus"  method="POST" id="auctionForm" class="profile" enctype="multipart/form-data">
          <caption>Update Auction status to closed if you wish to end the auction sooner<br></caption>
            {{ csrf_field() }}
            
            <input type="hidden" name="auction" value="{{ $auction->id }}">
            <input type="hidden" name="close" value="true">
            <label id="error"></label> <br> 

            <button id="buttonInvBack" class="btn btn-outline-light btn-lg px-5" type="submit" >Close Sooner</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>






