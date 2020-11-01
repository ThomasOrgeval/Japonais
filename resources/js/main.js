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

$(document).ready(function () {

    $('#riddle-btn').click(function (e) {
        e.preventDefault();
        $.post(
            'ajax/riddle.php',
            {
                value: $('#value').val()
            },
            function (data) {

                $.get('ajax/getsession.php', function (get) {
                    const session = $.parseJSON(get);
                    if (data === 'Success') {
                        $('#result').html("<p class='green-text'>Bonne réponse !</p>");
                        let points = parseInt(document.getElementById('points').innerHTML) + 20;
                        $('#points').html(points);
                    } else if (data === 'Failed') {
                        $('#result').html("<p class='red-text'>Dommage, c'est une mauvaise réponse :(</p>");
                    }
                    $('#riddle-value').html("<p>" + session['riddle'] + "</p>");
                    //$('#riddle-value').load('view/frontend/index.php #riddle-value');
                });

            },
            'html'
        );
    });

});