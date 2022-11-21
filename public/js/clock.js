function startTime() {
    date = document.getElementById('hTime').innerHTML
    var jsDate = new Date(date * 1000);
    const today = new Date();

    var diffTime = Math.abs(jsDate - today) /1000;

    var days = Math.floor(diffTime / 86400);
    diffTime -= days * 86400;
    if (days>0){
        days = days + "d "
    }
    else{
        days = ""
    }


    // calculate (and subtract) whole hours
    var hours = Math.floor(diffTime / 3600) % 24;
    diffTime -= hours * 3600;

    // calculate (and subtract) whole minutes
    var minutes = Math.floor(diffTime / 60) % 60;
    diffTime -= minutes * 60;

    // what's left is seconds
    var seconds = diffTime % 60;  // in theory the modulus is not required
    seconds = Math.floor(seconds);

    if (hours > 0){
      hours = hours + "h "
    }
    else{
      hours = ""
    }
    
    if (minutes > 0){
      minutes = minutes + "m "
    }
    else{
       minutes = ""
    }
    
    document.getElementById('clock').innerHTML ="Closes in: "+  days + hours + minutes + seconds + "s";
    setTimeout(startTime, 1000);
    
  }
  
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }


  