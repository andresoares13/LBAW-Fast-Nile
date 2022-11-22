<form action="{{ url('/wallet')}}" method="POST" id="walletForm" class="profile" onsubmit="return checkWalletValue()">

  

<label for="funds">Choose the amount you want to add <br> <br></label>
    <script src="{{ asset('js/pages1.js') }}"></script>
    {{ csrf_field() }}
    <input id="fundsInput" type="text" onkeypress="return checkNumber(event)" name="funds" value="500" required autofocus><i> €<i>
    <label id="error"></label>
    <input type="hidden" name="user" value="{{ Auth::user()->id }}">

  
  <button type="submit" onclick="return checkWalletValue()" >Add Funds</button>

  <p id="error_messages" style="color: black">
    <?php if(isset($_SESSION['ERROR'])) echo htmlentities($_SESSION['ERROR']); unset($_SESSION['ERROR'])?>
  </p>
</form>