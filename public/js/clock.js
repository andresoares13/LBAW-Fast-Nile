let auction = null;
var path = window.location.pathname;
var page = path.split("/").pop();

function encodeForAjaxx(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}

function sendAjaxxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();
  
  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjaxx(data));
}

function receiveAuctionHandler(){
  if (this.status != 200){
    return;
  }
  
  auction = JSON.parse(this.responseText);
}

function closeAuctionHandler(){
  if (this.status != 200){
    return;
  }
  window.location.reload();
  

}

function endingAuctionHandler(){
  if (this.status != 200){
    return;
  }
  auction = null;
}

function setAuctionNull(){
  auction =  null;
}



function startTime() {
    date = document.getElementById('hTime').innerHTML
    var jsDate = new Date(date * 1000);
    if (auction != null){
      jsDate = new Date(auction.timeclose);
    }
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

    if (auction == null){
      if (page =="home"){
        soon = document.getElementById('soon').innerHTML;
        sendAjaxxRequest('post', '/api/getAuction/',{"id":soon},receiveAuctionHandler);
      }
      else{
        sendAjaxxRequest('post', '/api/getAuction/',{"id":page},receiveAuctionHandler);
      }
      

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

    if (seconds <= 0){
      seconds=""
    }
   
 
    if (isNaN(parseInt(days)) && isNaN(parseInt(hours)) && auction != null){
      console.log(isNaN(parseInt(minutes)),isNaN(parseInt(seconds)),auction.states)
      if (isNaN(parseInt(minutes)) && isNaN(parseInt(seconds)) && auction.states != "Closed"){
        sendAjaxxRequest('post', '/api/closeAuction/',{"id":page},closeAuctionHandler);
      }
      else if (parseInt(minutes) < 15 && !auction.ending){
        sendAjaxxRequest('post', '/api/endingAuction/',{"id":page},endingAuctionHandler);
      }
    }
    
    document.getElementById('clock').innerHTML =days + hours + minutes + seconds + "s";
    setTimeout(startTime, 1000);
    
  }
  
  function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
  }


  