
let categoriesForm = document.getElementById("categoriesForm")
let statesForm = document.getElementById("statesForm")

function updateForms(form){ 
    if (form == 'states'){
        //statesForm.action = statesForm.action + '&states=' + document.getElementById('states').value
        statesForm.action = "/actions/1"
        console.log(statesForm.action)
        statesForm.submit();
    }
    
}



