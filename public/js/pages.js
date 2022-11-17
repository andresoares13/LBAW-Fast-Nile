function checkNumber(event) {
    var aCode = event.which ? event.which : event.keyCode;
    if (aCode > 31 && (aCode < 48 || aCode > 57)) return false;
    
    return true;
}


function checkBidValue() {
    if (parseInt(document.getElementById('bidInput').value) < parseInt(document.getElementById('startValue').innerHTML)){
        console.log("hye");
        return false
    }
    return true;
}

function checkWalletValue() {
    if (parseInt(document.getElementById('fundsInput').value) < 500 || parseInt(document.getElementById('fundsInput').value) > 50000){
        return false
    }
    return true;
}


