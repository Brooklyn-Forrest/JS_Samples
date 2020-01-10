function switchenable() {

    var childobj = document.getElementById("Vendor").getElementsByTagName("input");
    for (let obj in childobj) {
        if (childobj[obj] == childobj.length)
            break;
        if (childobj[obj].disabled) {
            childobj[obj].removeAttribute('disabled');
        } else {
            childobj[obj].setAttribute('disabled', 'disabled');
        }

    }

    var childobj2 = document.getElementById("Family").getElementsByTagName("input");
    for (let obj2 in childobj2) {
        if (childobj2[obj2] == childobj2.length)
            break;
        if (childobj2[obj2].disabled) {
            childobj2[obj2].removeAttribute('disabled');
        } else {
            childobj2[obj2].setAttribute('disabled', 'disabled');
        }
    }

    var childobj3 = document.getElementById("Data_Center").getElementsByTagName("input");
    for (let obj3 in childobj3) {
        if (childobj3[obj3] == childobj3.length)
            break;
        if (childobj3[obj3].disabled) {
            childobj3[obj3].removeAttribute('disabled');
        } else {
            childobj3[obj3].setAttribute('disabled', 'disabled');
        }
    }

    var childobj4 = document.getElementById("Company_Subsidiary").getElementsByTagName("input");
    for (let obj4 in childobj4) {
        if (childobj4[obj4] == childobj4.length)
            break;
        if (childobj4[obj4].disabled) {
            childobj4[obj4].removeAttribute('disabled');
        } else {
            childobj4[obj4].setAttribute('disabled', 'disabled');
        }
    }
}