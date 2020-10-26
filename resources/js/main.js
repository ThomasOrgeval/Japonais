function showResult(str) {
    if (str.length === 0) {
        document.getElementById("search").innerHTML = "";
        document.getElementById("search").style.border = "0px";
        return;
    }
    var xmlhttp;
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xmlhttp = new XMLHttpRequest();
        }
    } else {
        xmlhttp = new XMLHttpRequest();
    }

    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("search").innerHTML = this.responseText;
            document.getElementById("search").style.border = "1px solid #A5ACB2";
        }
    }
    xmlhttp.open("GET", "index.php?p=search&search=" + str, true);
    xmlhttp.send();
}