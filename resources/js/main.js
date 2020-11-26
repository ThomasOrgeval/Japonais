function toast() {
    const x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function () {
        x.className = x.className.replace("show", "");
    }, 3000);
}

function addToList(id_liste, id_mot) {
    $.post(
        'ajax/addList.php',
        {
            id_liste: id_liste,
            id_mot: id_mot
        },
        function (data) {
            if (data === 'ADD') {
                $('#li-' + id_liste + ' > div > svg').attr('id', 'check');
                $('#li-' + id_liste + ' > div > svg > path').attr('d', 'M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z');
            } else if (data === 'REMOVE') {
                $('#li-' + id_liste + ' > div > svg').attr('id', 'uncheck');
                $('#li-' + id_liste + ' > div > svg > path').attr('d', 'M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z');
            }
        },
        'html'
    );
}

function textToAudio(msg) {
    let speech = new SpeechSynthesisUtterance();
    speech.lang = "ja";
    speech.text = msg;
    speech.volume = 1;
    speech.rate = 1;
    speech.pitch = 1;

    window.speechSynthesis.speak(speech);
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

                $.get('ajax/getSession.php', function (get) {
                    const session = $.parseJSON(get);
                    if (data === 'Success') {
                        $('#result').html("<p class='green-text'>Bonne réponse !</p>");
                        let points = parseInt(document.getElementById('points').innerHTML) + 20;
                        $('#points').html(points);
                        $('#riddle-value').html(session['riddle']);

                        toast();
                    } else if (data === 'Failed') {
                        if (session['life'] === 0) {
                            $('#riddle-form').remove();
                            $('#riddle').append("<br/><br/><p class='card-text'>Vous n'avez plus de vie, revenez demain !</p>");
                        } else {
                            $('#result').html("<p class='red-text'>Dommage, ce n'est pas ça !</p>");
                            $('#life').html(session['life']);
                            $('#riddle-value').html(session['riddle']);
                        }
                    }
                    $('#value').val("");
                });

            },
            'html'
        );
    });

    $('#autocomplete').keyup(function () {
        $.ajax({
            type: "POST",
            url: "ajax/getAutocomplete.php",
            data: 'keyword=' + $(this).val(),
            success: function (data) {
                $('#search').show().html(data);
                $('#autocomplete').css("background");
            }
        });
    });

    $('#autocompleteusers').keyup(function () {
        $.ajax({
            type: "POST",
            url: "ajax/getUsers.php",
            data: 'keyword=' + $(this).val(),
            success: function (data) {
                $('#search').show().html(data);
                $('#autocompleteusers').css("background");
            }
        });
    });

    $('#autocompleteListe').keyup(function () {
        const research = $.trim($(this).val());
        if (!research) {
            $('#searchListe > a >li').show();
        } else {
            $.expr[":"].contains = $.expr.createPseudo(function (text) {
                return function (elem) {
                    return $(elem).text().toLowerCase().indexOf(text.toLowerCase()) >= 0;
                };
            });
            $('#searchListe > a > li').show().not(':contains(' + research + ')').hide();
        }
    });

});