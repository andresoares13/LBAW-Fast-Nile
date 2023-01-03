function addListeners(){
    inputs = document.getElementById("inputStars").getElementsByTagName('input');
    
    for (let i=0;i<inputs.length;i++){
        inputs[i].nextSibling.addEventListener('click', addRating);
    }
}

function addRating(event){
    event.preventDefault();

    
    inputs = document.getElementById("inputStars").getElementsByTagName('input');
    for (let i=0;i<inputs.length;i++){
        
        if (i+1<=parseInt(event.target.id.split('icon')[1])){
            inputs[i].nextSibling.classList.remove('fa-regular');
            inputs[i].nextSibling.classList.add('fa-solid');
        }
        else{
            inputs[i].nextSibling.classList.remove('fa-solid');
            inputs[i].nextSibling.classList.add('fa-regular');
        }
        
    }
    inputs[parseInt(event.target.id.split('icon')[1])-1].checked = true
    
}