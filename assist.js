function loading(url, object){
    document.getElementById(object).innerHTML = '<img class="loading" src="isi-loading.gif">';
    if(url !== "") {
        window.location.href = url;
    }
}

function clearx(){
    document.getElementById("fileform").reset();
}