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
    return true;
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

