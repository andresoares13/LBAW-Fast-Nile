function checkNumber(event) {
    var aCode = event.which ? event.which : event.keyCode;
    if (aCode > 31 && (aCode < 48 || aCode > 57)) return false;
    
    return true;
}


function checkBidValue() {
    var r = /\d+/;
    var wal = document.getElementById('headerWallet').innerHTML
    if (parseInt(document.getElementById('bidInput').value) < parseInt(document.getElementById('startValue').innerHTML) + 1){

        errorMessage("The value of the bid has to be at least " + (parseInt(document.getElementById('startValue').innerHTML) +1 ))
        return false
    }
    
    else if (parseInt(document.getElementById('bidInput').value) > parseInt(wal.match(r)[0])){
        errorMessage("You don't have enough funds")
        return false
    }
    else if (document.getElementById('HighestBidder')!=null){
        
        if (parseInt(document.getElementById('HighestBidder').innerHTML) == document.getElementById('formUser').value){
            errorMessage("You already have the highest bid")
            return false
        }
    }
 
    document.getElementById('bidConfirm').style.display = "block"
    return true;
}

function closeBidConfirm(){
    document.getElementById('bidConfirm').style.display = "none"
}

function checkWalletValue() {
    if (parseInt(document.getElementById('fundsInput').value) < 500 || parseInt(document.getElementById('fundsInput').value) > 50000){
        errorMessage("The value of funds to be added has to be between 500 and 50000")
        return false
    }
    return true;
}

function checkConsumption(event) {
    var aCode = event.which ? event.which : event.keyCode;
    if (aCode > 31 && (aCode < 48 || aCode > 57) && aCode != 46) return false;
    
    if (aCode == 46 && document.getElementById('consumption').value.includes(".")){
        return false;
    }

    return true;
}

function checkCarValue() {
    if (parseInt(document.getElementById('priceStart').value) < 500 || parseInt(document.getElementById('priceStart').value) > 100000){
        errorMessage("The starting price has to be between 500 and 100000")
        return false
    }
    return true;
}


function errorMessage(s) {
    var error = document.getElementById("error")
        error.textContent = s
        error.style.color = "red"
    
}


function auctionDateRange(){
    let yourDate = new Date()
    let day = (yourDate.getDate() + 1).toString()
    let month = (yourDate.getMonth() + 1).toString()
    let year = (yourDate.getFullYear()).toString()
    if(day<10) 
    {
        day='0'+day;
    } 

    if(month<10) 
    {
        month='0'+month
    } 
    let minDate = year + "-" + month + "-" + day;
    let maxDate = (parseInt(year) + 5).toString() + "-" + month + "-" + day;
    document.getElementById('timeClose').min = minDate
    document.getElementById('timeClose').max = maxDate
}


//ajax bid


function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
  }
  
  function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
    
    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }
  

  function addEventListeners() {
    if (document.getElementById('finalBidButton') != null){
        let bidCreators = document.getElementById('finalBidButton');
        bidCreators.addEventListener('click', sendBidRequest);
    }
    if (document.getElementById('auctionFollow') != null){
        button = document.getElementById('auctionFollow').getElementsByTagName('button')[0];
        button.addEventListener('click',sendFollowRequest);
    }
    if (document.getElementById('auctionUnFollow') != null){
        button = document.getElementById('auctionUnFollow').getElementsByTagName('button')[0];
        button.addEventListener('click',sendUnFollowRequest);
    }      
    if (document.getElementById('walletForm') != null){
        button = document.getElementById('walletForm').getElementsByTagName('button')[0];
        button.addEventListener('click',sendFundsRequest);
    }

  }

  function sendFollowRequest(event){
    event.preventDefault();
    let user = document.getElementById('formUser').value;
    let auction = document.getElementById('formAuction').value;
    sendAjaxRequest('post', '/api/auctionFollow/',{"user": user,"auction": auction},followHandler);
    event.preventDefault();
  }

  function followHandler(){
    if (this.status != 200){
        return;
    }
    button = document.getElementById('auctionFollow').getElementsByTagName('button')[0];
    button.innerHTML = 'Following';
    document.getElementById('auctionFollow').id='auctionUnFollow';
    button.removeEventListener('click',sendFollowRequest);
    button.addEventListener('click',sendUnFollowRequest);
    button.classList.add('following');
  }

  function sendUnFollowRequest(event){
    event.preventDefault();
    let user = document.getElementById('formUser').value;
    let auction = document.getElementById('formAuction').value;
    sendAjaxRequest('post', '/api/auctionUnFollow/',{"user": user,"auction": auction},unfollowHandler);
    event.preventDefault();
  }

  function unfollowHandler(){
    if (this.status != 200){
        return;
    }
    button = document.getElementById('auctionUnFollow').getElementsByTagName('button')[0];
    button.innerHTML = 'Follow Auction';
    document.getElementById('auctionUnFollow').id='auctionFollow';
    button.removeEventListener('click',sendUnFollowRequest);
    button.addEventListener('click',sendFollowRequest);
    button.classList.remove('following');
  }




  function sendFundsRequest(event){
    event.preventDefault();
    okMessage("")
    let funds = document.getElementById('fundsInput').value;
    if (funds < 500 || funds > 50000){
        errorMessage("The value of funds to be added has to be between 500 and 50000");
        return;
    }
    let user = document.getElementById('formUser').value;
    sendAjaxRequest('post', '/api/wallet/',{"funds": funds,"user": user},fundsAddHandler);

    event.preventDefault();
  }




  function fundsAddHandler(){
    if (this.status != 200){
        errorMessage("There was an error while adding the funds");
        return;
    }
    okMessage("Funds were added!");
    let funds = JSON.parse(this.responseText);
    document.getElementById('headerWallet').innerHTML='Wallet: ' + funds + ' €';
    document.getElementById('currentFunds').innerHTML = funds + ' €';
  }


  function sendBidRequest(event) {
    event.preventDefault();
    let auction = document.getElementById('formAuction').value;
    let user = document.getElementById('formUser').value;
    let bid = document.getElementById('bidInput').value;
    sendAjaxRequest('post', '/api/bid/', {"auction": auction,"user": user,"bid": bid}, bidMadeHandler);
  
    event.preventDefault();
  }


  function bidMadeHandler() {
    if (this.status != 200){
        errorMessage("There was an error while making the bid");
        return;
    }
    
    okMessage("Bid was Made!")
    

    
  
   
  }

  function okMessage(s) {
    var error = document.getElementById("error")
        error.textContent = s
        error.style.color = "green"
    
}

function footerFix(){
    var footer = document.getElementById("footer");
    footer.style.position = "static";
}




function checkSize(){
    window.URL = window.URL || window.webkitURL;  
  var file = document.getElementById("imageInput");
  
  if (file && file.files.length > 0) 
  {
        var img = new Image();
        
        
        img.src = window.URL.createObjectURL( file.files[0] );
        return img.onload = function(width,height) 
        {
            width = this.naturalWidth,
            height = this.naturalHeight;
           
                
          if (width < 800 || height < 700){
            errorMessage("The car picture needs to be at least 800x700")
            file.value="";
          }
          
     
        };
    }
   
}



var path = window.location.pathname;
var page = path.split("/");

if (page[1]=='auction'){

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;

    var pusher = new Pusher('ef60f01b5d6f9e11314e', {
    cluster: 'eu'
    });

    var channel = pusher.subscribe('public.bid.1');
    channel.bind('newBid', function(data) {

    bid=JSON.stringify(data);
    bid = JSON.parse(bid);


    if (document.getElementById('bidConfirm') !=null){
        document.getElementById('bidConfirm').style.display = "none"
        document.getElementById('bidInput').value = Math.floor(parseInt(bid.valuee) * 1.05) +1
    }
        
        document.getElementById('currentPriceText').innerHTML = ': '+bid.valuee+' €'
        document.getElementById('startValue').innerHTML = Math.floor(parseInt(bid.valuee) * 1.05);
        document.getElementById('HighestBidder').innerHTML = bid.iduser;

        let tbl = document.getElementById('tables')
        let tr2 = document.createElement('tr');
        let td1= document.createElement('td');
        let td2= document.createElement('td');
        let td3= document.createElement('td');
        td1.innerHTML = "1";
        td2.innerHTML = bid.valuee + ' €';
        let anchor = document.createElement('a');
        anchor.href= "/users/"+bid.iduser;
        anchor.innerHTML=bid.username;
        td3.appendChild(anchor);
        tr2.appendChild(td1);
        tr2.appendChild(td2);
        tr2.appendChild(td3);
        let previousRows = tbl.querySelector('tbody').children;
        if (previousRows[0].children[1].innerHTML == "No Bids Yet"){
            previousRows[0].parentNode.removeChild(previousRows[0])
        }
        tbl.querySelector('tbody').insertBefore(tr2,tbl.querySelector('tbody').children[0]);
        for (let i=0;i<previousRows.length;i++){
            if (i!=0){
                previousRows[i].children[0].innerHTML = parseInt(i)+1;
            }
        }
        while (previousRows.length > 5){
            previousRows[5].parentNode.removeChild(previousRows[5])
        }

        if (document.getElementById('auctionCancel') != null){
            button = document.getElementById('auctionCancel').getElementsByTagName('button')[0];
            button.parentNode.removeChild(button);
        }
   
        
    });
}





  
  
