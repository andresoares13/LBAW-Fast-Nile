<div class="contact-section">
  <h1>Contacts</h1>
  <div style="padding:0 0 0 3.5%;">
  <h2>For customer support, use these!</h2>
  <p>Email: <a href="#">fastnileweb@gmail.com</a></p>
  <p>Phone: <a href="#">+351 987 654 321</a></p>
  <h2>To professionally contact us, use these!</h2>
  <p>Email: <a href="#">fastnilebusiness@gmail.com</a></p>
  <p>Phone: <a href="#">+351 999 888 777</a></p>
  </div>
</div>

<h3>Meet Our Team!</h3>
<div class="row">
  <div class="column">
    <div class="card">
      <img class="pfp" src="{{asset('img/andre.jpg/')}}">
      <div class="container">
        <h2>André Soares</h2>
        <p class="title">CEO & Founder</p>
        <p class="description">This is the big guy with big money and big brain.</p>
        <p><a href="https://www.linkedin.com/in/williamhgates">Linkedin</a></p>
        <p><a href="#">+351 989 321 765</a></p>
        <p><a href="#">andrefn@gmail.com</a></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img class="pfp" src="{{asset('img/antonio.jpg/')}}">
      <div class="container">
        <h2>António Matos</h2>
        <p class="title">Art Director</p>
        <p class="description">This is the goofy guy, he specializes in stuff.</p>
        <p><a href="https://www.linkedin.com/in/williamhgates">Linkedin</a></p>
        <p><a href="#">+351 966 999 321</a></p>
        <p><a href="#">antoniofn@gmail.com</a></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img class="pfp" src="{{asset('img/joao.jpg/')}}">
      <div class="container">
        <h2>João Moura</h2>
        <p class="title">Designer</p>
        <p class="description">This is other guy, he does the good thing.</p>
        <p><a href="https://www.linkedin.com/in/williamhgates">Linkedin</a></p>
        <p><a href="#">+351 988 333 666</a></p>
        <p><a href="#">joaofn@gmail.com</a></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img class="pfp" src="{{asset('img/miguel.jpg/')}}">
      <div class="container">
        <h2>Miguel Teixeira</h2>
        <p class="title">Creative Director</p>
        <p class="description">This is the man who has the skill to do it (or not).</p>
        <p><a href="https://ca.linkedin.com/in/rebecca-ford-9905242a">Linkedin</a></p>
        <p><a href="#">+351 977 123 666</a></p>
        <p><a href="#">miguelfn@gmail.com</a></p>
      </div>
    </div>
  </div>

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

h3{
  text-align: center;
  padding: 20px 50px 20px 50px;
  font-size: 250%;
}

.column {
  float: left;
  width: 25%;
}

.row{
  align: center;
  margin-left: 5%;
  margin-right: 5%;
  margin-bottom: 16px;
}

.card {
  box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.2);
  margin: 0%;
}

.description {
  padding: 0 0 7% 0;
}

.card p {
    font-size: 100%
    padding: 0;
    margin: 0;
}


.contact-section {
  padding: 100px 50px 30px 50px;
  text-align: left;
  background-color: #474e5d;
  color: white;
}
.contact-section h1 {
  text-align: center;
  padding: 0 50px 5px 50px;
  font-size: 250%;
}

.contact-section h2 {
  font-size: 210%;
  padding: 10px 0 0 0px;
}

.contact-section p {
  padding: 0 0 0 0;
  margin: 0;
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