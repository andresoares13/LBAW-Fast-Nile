function checkNumber(event) {
    var aCode = event.which ? event.which : event.keyCode;
    if (aCode > 31 && (aCode < 48 || aCode > 57)) return false;
    
    return true;
}


function checkBidValue() {
    if (parseInt(document.getElementById('bidInput').value) < parseInt(document.getElementById('startValue').innerHTML) + 1){

        errorMessage("The value of the bid has to be at least " + (parseInt(document.getElementById('startValue').innerHTML) +1 ))
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
    let bidCreators = document.getElementById('finalBidButton');
    bidCreators.addEventListener('click', sendBidRequest);
  }


  function sendBidRequest(event) {
    event.preventDefault();
    let auction = document.getElementById('formAuction').value;
    let user = document.getElementById('formUser').value;
    let bid = document.getElementById('bidInput').value;
  
    if (description != '')
      sendAjaxRequest('post', '/api/bid/', {"auction": auction,"user": user,"bid": bid}, bidMadeHandler);
  
    event.preventDefault();
  }


  function bidMadeHandler() {
    if (this.status != 200) window.location = '/auction/' + document.getElementById('formAuction').value;
    let bid = JSON.parse(this.responseText);
    okMessage("Bid was Made")
    document.getElementById('bidConfirm').style.display = "none"
    document.getElementById('currentPriceText').innerHTML = 'Current price: '+bid.valuee
    document.getElementById('bidInput').value = Math.floor(parseInt(bid.valuee) * 1.05) +1
    document.getElementById('startValue').innerHTML = Math.floor(parseInt(bid.valuee) * 1.05);
    document.getElementById('HighestBidder').innerHTML = bid.iduser;
    if (document.getElementById('bids?').innerHTML == "No Bids yet"){
        let tbl = document.getElementById('tables')
        document.getElementById("bids?").parentNode.removeChild(document.getElementById('bids?'));
        let th1= document.createElement('th');
        let th2= document.createElement('th');
        let th3= document.createElement('th');
        let tr1 = document.createElement('tr');
        th1.innerHTML = "Bid";
        th1.scope = "col"
        th2.innerHTML = "Value";
        th2.scope = "col"
        th3.innerHTML = "User";
        th3.scope = "col"
        tr1.appendChild(th1);
        tr1.appendChild(th2);
        tr1.appendChild(th3);
        tbl.appendChild(tr1);
        let tr2 = document.createElement('tr');
        let td1= document.createElement('td');
        let td2= document.createElement('td');
        let td3= document.createElement('td');
        td1.innerHTML = "1";
        td2.innerHTML = bid.valuee;
        td3.innerHTML = bid.username;
        tr2.appendChild(td1);
        tr2.appendChild(td2);
        tr2.appendChild(td3);
        tbl.appendChild(tr2);

    }
    else{
        let tbl = document.getElementById('tables')
        let tr2 = document.createElement('tr');
        let td1= document.createElement('td');
        let td2= document.createElement('td');
        let td3= document.createElement('td');
        td1.innerHTML = "1";
        td2.innerHTML = bid.valuee;
        td3.innerHTML = bid.username;
        tr2.appendChild(td1);
        tr2.appendChild(td2);
        tr2.appendChild(td3);
        let previousRows = tbl.querySelector('tbody').children;
        tbl.querySelector('tbody').insertBefore(tr2,tbl.querySelector('tbody').children[1]);
        for (let i=0;i<previousRows.length;i++){
            if (i!=0){
                previousRows[i].firstChild.innerHTML = i;
            }
        }
     
    }
    
  
   
  }

  function okMessage(s) {
    var error = document.getElementById("error")
        error.textContent = s
        error.style.color = "green"
    
}


  
  
