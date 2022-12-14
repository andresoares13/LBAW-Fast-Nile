<h1>Main Features</h1>

<div class="row">
  <div class="column">
    <div class="card">
      <div style="padding: 0 0 15px 0;">
        <img class="pfp" src="{{asset('img//icons/search.png/')}}">
        <h2>Search</h2>
        <p class="description">Easily find any auction or user that you're looking for, all you have to do is type the name.</p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card"> 
    <div style="padding: 0 0 15px 0;">
    	<img class="pfp" src="{{asset('img//icons/bid.png/')}}">
        <h2>Bid</h2>
        <p class="description">See an auction you like? You can place a bid on it to try to win!</p>
    </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
    	<img class="pfp" src="{{asset('img//icons/review.png/')}}">
        <h2>Review</h2>
        <p class="description">Give a grade to the auctioneers of the auctions you won. Let everyone know the quality of their service.</p>
    </div>
    </div>
  </div>
  
</div>

<div class="row">
  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
        <img class="pfp" src="{{asset('img//icons/phone.png/')}}">
        <h2>Become Auctioneer</h2>
        <p class="description">Anyone can become an auctioneer, all you have to do is add a phone number to your account so we can better confirm you are a real person and anyone participating in your auctions can contact you easily.</p>
    </div>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
        <img class="pfp" src="{{asset('img//icons/create_auction.png/')}}">
        <h2>Create Auction</h2>
        <p class="description">If you have a car you want to sell, you can create your own auction and sell your car for the highest price!</p>
    </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
        <img class="pfp" src="{{asset('img//icons/edit.png/')}}">
        <h2>Edit Profile</h2>
        <p class="description">Everyone can see your profile, so if you want to customize it to better represent you, you can do it! You can change your name, profile picture, adress or phone number anytime you want. </p>
    </div>
    </div>
  </div>

</div>
<div class="row">
    <div class="column">
      <div class="card">
      <div style="padding: 0 0 15px 0;">
      <img class="pfp" src="{{asset('img//icons/funds.png/')}}">
      <h2>Add funds</h2>
      <p class="description">In order to bid, you need your wallet ready. As so, you can add funds to it in the amount you see fit.</p>
        </div>
      </div>
  </div>

  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
    <img class="pfp" src="{{asset('img//icons/notification.png/')}}">
    <h2>Follow Auction</h2>
    <p class="description">If you're really interested in the development of an auction you can follow it, so you'll be updated every time something happens.</p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
    <img class="pfp" src="{{asset('img//icons/help.png/')}}">
    <h2>Get Help</h2>
        <p class="description">If you have any problems, there are pages to help you. If you need to contact the company or a specific employee, you should check the contacts page. Or if you have any doubts about the website check the About Us, FAQ or Main Features page.</p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
    <img class="pfp" src="{{asset('img//icons/register.png/')}}">
    <h2>Register</h2>
        <p class="description">If you want to participate in any auction, you'll have to first create an account, which can be done very quickly by registering your information.</p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
    <img class="pfp" src="{{asset('img//icons/login.png/')}}">
    <h2>Login / Logout</h2>
    <p class="description">To access an account a log-in with your password is necessary. For safety reasons, it's always best to logout after using the website.</p>
    </div>
  </div>
  </div>

  <div class="column">
    <div class="card">
    <div style="padding: 0 0 15px 0;">
      <img class="pfp" src="{{asset('img//icons/password.png/')}}">
      <h2>Password Recovery</h2>
      <p class="description">In the unfortunate case of forgetting your password, our system will help you getting your account back.</p>
    </div>
    </div>
  </div>
</div>


  <style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}


h1{
  text-align: center;
  padding: 100px 50px 20px 50px;
  font-size: 250%;
}

.column {
  width: 33.3%;
}

.row{
  align: center;
  margin-left: 5%;
  margin-right: 5%;
  margin-bottom: 16px;
}


.card {
  box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.2);  
}
.card h2 {
    padding: 10px 0 0 0;
    width:100%;
    align:center;
}

.card > .container{
    
}

.card  .pfp{
    width: 30%;
    padding: 4% 3% 0% 3%;
    float:left;
    filter: invert(21%) sepia(48%) saturate(15%) hue-rotate(19deg) brightness(94%) contrast(80%);
}
.card p {
    font-size: 100%
    padding: 0;
    margin: 0;
    padding: 0 15px 8px 15px;
    width:100%;
}


.title {
  color: grey;
}


</style>