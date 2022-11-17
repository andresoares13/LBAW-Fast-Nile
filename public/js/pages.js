function checkNumber(event) {
    var aCode = event.which ? event.which : event.keyCode;
    if (aCode > 31 && (aCode < 48 || aCode > 57)) return false;
    
    return true;
}


function checkBidValue() {
    console.log(document.getElementById('startValue').innerHTML);
    if (document.getElementById('bidInput').value < document.getElementById('startValue').innerHTML){
        return false
    }
    return true;
}
