function addNotificationListeners(){
    if (document.getElementById('notificationDrop') != null){
        button = document.getElementById('notificationDrop').getElementsByTagName('i');
        for (let i=0;i<button.length;i++){
            button[i].id = i+1;
            button[i].addEventListener('click',markSeen);
        }
    }

    if (document.getElementById('markAllRead') != null){
        button = document.getElementById('markAllRead').getElementsByTagName('button')[0];
        button.addEventListener('click',markAllSeen);
    }
}

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

function markSeen(event){
    event.preventDefault();
    row = event.currentTarget.id
    notification = document.getElementById('notificationDrop').getElementsByTagName('i')[row-1].getElementsByTagName('input')[0].value;
    sendAjaxRequest('post', '/api/markRead/',{"id": notification,"row": row},markReadHandler);
    event.preventDefault();
}  

function markReadHandler(){
    if (this.status != 200){
        return;
    }
    data = JSON.parse(this.responseText);
    notis = document.getElementById('notificationDrop').getElementsByTagName('i');
    row = notis[data[0]-1];
    div = row.parentNode;
    for (let i=0;i<notis.length;i++){
        if (notis[i].id > data[0]){
            notis[i].id -= 1;
        }
    }
    div.parentNode.removeChild(div);
    Num = document.getElementById('notificationNumber');
    Num.innerHTML = Num.innerHTML - 1;
    if (parseInt(Num.innerHTML) == 0){
        Num.style.display="none";
        document.getElementById('noNotis').style.display = "block"
    }
    if (document.getElementById('allNotifications') != null){
        let inputs = document.getElementById('allNotifications').getElementsByTagName('input');
        for (let i=0;i<inputs.length;i++){
            if (inputs[i].value == data[1]){
                inputs[i].parentNode.classList.remove('unseen');
            }
        }
    }
    
}

function markAllSeen(event){
    event.preventDefault();
    sendAjaxRequest('post', '/api/markAllRead/',{},markAllReadHandler);
    event.preventDefault();
}  



function markAllReadHandler(){
    if (this.status != 200){
        return;
    }
    notis = document.getElementById('notificationDrop');
    Num = document.getElementById('notificationNumber');
    let count =notis.children.length -2;
    while (count > 0){
        if (notis.firstChild.className == "dropdown-item header-noti"){
            Num.innerHTML = Num.innerHTML - 1;
            count-=1;
        }
        console.log(notis.firstChild);
        notis.removeChild(notis.firstChild);
    }
    if (parseInt(Num.innerHTML) == 0){
        Num.style.display="none";
        document.getElementById('noNotis').style.display = "block"
    }
    if (document.getElementById('allNotifications') != null){
        let inputs = document.getElementById('allNotifications').getElementsByTagName('input');
        for (let i=0;i<inputs.length;i++){
            inputs[i].parentNode.classList.remove('unseen');
        }
    }
    
}