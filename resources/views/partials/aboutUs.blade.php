<div class="about-section">
  <h1>About Us Page</h1>
  <h2>Who are we?</h2>
  <p>We are a fairly recent company that's been making the rounds as of late!</p>
  <h2>Where are we?</h2>
  <p>Our headquarters are located in Portugal, specifically in a building right next to the Faculty of Engineering in Porto.</p>
  <h2>Our goal?</h2>
  <p>We have one mission: helping you out in buying cars or selling yours (which is technically two missions).</p>
</div>

<div class="pic-section">
  <img class="office" src="{{asset('img/backgrounds/office.jpg/')}}">
  <h3>Totally legitimate photo of our headquarters!</h3>
</div>

<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

.pic-section {
  padding: 0px 50px 7px 50px;
  text-align: center;
  background-image:url({{asset('img/backgrounds/office_fundo.jpg')}});;
}

h3{
  color:white;
}

.office{
  width: 88%;
  max-width: 1000px;
  align: center;
  margin: 1.5% 6% 0.5% 6%;
}
.about-section {
  padding: 100px 50px 50px 50px;
  text-align: left;
  background-color: #474e5d;
  color: white;
}

.about-section h1 {
  padding:0 0 25px 0;
  text-align: center;
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}

</style>
