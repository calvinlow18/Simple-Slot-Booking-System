var slots = '';
var msg = '';

function ajaxRequest(){
    var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
    if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
        for (var i=0; i<activexmodes.length; i++){
            try{
                return new ActiveXObject(activexmodes[i])
            }
            catch(e){
                //suppress error
            }
        }
    } else if (window.XMLHttpRequest) // if Mozilla, Safari etc
        return new XMLHttpRequest()
    else
        return false
}


function getSlots(date) {
    var xmlhttp=new ajaxRequest()
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200 || window.location.href.indexOf("http") == -1) {
                slots = xmlhttp.responseText;
                //document.getElementById("timeFieldSet").innerHTML = slots;
                setDisableTime(slots);
            } else {
                alert("An error has occured making the request")
            }
        }
    }

    var dateValue=encodeURIComponent(document.getElementById("date").value)
    var parameters="date="+dateValue
    xmlhttp.open("POST", "setTime.php", true)
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xmlhttp.send(parameters)
}

function setDisableTime(jsonStr) {
    
    tPicker.set('enable', true);

    var objs = JSON.parse(jsonStr);
    var disableTime = []
    for (i = 0; i < objs.length; i++) {
        var timeArr = []
        timeArr.push(objs[i]['hour'])
        timeArr.push(objs[i]['mins'])
        disableTime.push(timeArr)
    }
    tPicker.set('disable', disableTime);

    if (chgDateFormat(today) == document.getElementById('date').value) {
        if (today.getHours() < 11) {
            tPicker.set('min', [11, 0]);
            tPicker.set('select', [11, 0]);
        } else {
            tPicker.set('min', true);
            tPicker.set('select', tPicker.get('min'));
            if(today.getHours() > 17) {
                var tmr = new Date();
                tmr.setDate(tmr.getDate() + 1);
                dPicker.set('select', tmr);
                dPicker.set('disable', [new Date()]);
                
            }
        }
    } else {
        tPicker.set('min', [11, 0]);
        tPicker.set('select', [11, 0]);
    }
    
}

function chgDateFormat(date) {
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
];
    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();
    return day + " " + monthNames[monthIndex] + ", " + year;
}

function numberInput() {
    var pax = document.getElementById("pax").value
    if (pax < 1) {
        pax = 1
    } else if (pax > 8) { 
        pax = 8
    }
    document.getElementById('ticketID').rows = pax
}

function formSubmit() {

    var recaptchaRsp = grecaptcha.getResponse()

    var xmlhttp = new ajaxRequest()
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            alert("xml status = " + xmlhttp.status)
            alert("xml status = " + window.location.href.indexOf("http"))
            if (xmlhttp.status == 200 || window.location.href.indexOf("http") == -1) {
                alert(xmlhttp.responseText)
            } else {
                alert("An error has occured making the request")
            }
        }
    }

    var dateValue = encodeURIComponent(document.getElementsByName("date").item(0).value);

    var timeValue = encodeURIComponent(document.getElementsByName("time").item(0).value)
    var nameValue = encodeURIComponent(document.getElementById("name").value)
    var emailValue = encodeURIComponent(document.getElementById("email").value)
    var contactValue = encodeURIComponent(document.getElementById("contact").value)
    var paxValue = encodeURIComponent(document.getElementById("pax").value)
    var ticketValue = encodeURIComponent(document.getElementById("ticketID").value)
    var parameters = "date=" + dateValue + "&time=" + timeValue + "&name=" + nameValue + "&email=" + emailValue + "&contact=" + contactValue + "&pax=" + paxValue + "&ticketID=" + ticketValue + "&recaptcha=" + recaptchaRsp
    xmlhttp.open("POST", "formSubmit.php", false)
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    xmlhttp.send(parameters)
    
}

function validateForm() {

    if (grecaptcha.getResponse() != "") {
        formSubmit()
        return true
    } else {
        alert("Please verify yourself.")
        return false
    }

}