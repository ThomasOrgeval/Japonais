function toast(value) {
    const x = document.getElementById("snackbar");
    $('#snackbar').text(value);
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

function riddleGroup(group) {
    let mots = [];
    $.post(
        'ajax/riddleGroup.php',
        {
            group: group
        },
        function (data) {
            if (data.startsWith('success')) {
                data = data.split(' -- ')[1];
                mots = data.split('/');
                mots.pop();
                const riddle = mots.shift();
                changeRiddle(mots, riddle, null);
            } else {
                console.log(data);
            }
        }
    )
}

function changeRiddle(mots, riddle, code, value = 2) {
    const shallowCopy = mots.slice();
    const riddleCopy = riddle;

    if (code === null) code = '';
    else if (code === 1) code = '<div class="green-text" id=\'result\'>Bravo !</div>';
    else if (code === 2) code = '<div class="red-text" id=\'result\'>Dommage :(</div>';

    $('#card').empty().html("<h6 class='card-title font-weight-bold'>Trouve la bonne traduction !</h6>" +
        "<form id='riddle-form-aux'>" +
        "<div id='riddle-div' class='flexible'>" +
        "<p id='riddle-value' class='card-text' style='font-size: 100%'>" + riddleCopy + "</p>" +
        "</div>" +
        code +
        "<input type='text' id='value' class='form-text riddle' autoComplete='off' required>" +
        "<div class=\"progress\" style='height: 3px;'>\n" +
        "  <div class=\"progress-bar\" role=\"progressbar\" style=\"width: " + value + "%\" aria-valuenow=\"2\" aria-valuemin=\"0\" aria-valuemax=\"100\"></div>\n" +
        "</div>" +
        "<input type='submit' id='riddle-btn-aux' class='btn btn-primary' value='Valider'>" +
        "<input type='hidden' id='array' value='" + shallowCopy + "'>" +
        "<input type='hidden' id='riddle' value='" + riddleCopy + "'>" +
        "</form>");

    $('#riddle-form-aux').submit(function (e) {
        $.post(
            'ajax/riddleGroup.php',
            {
                value: $('#value').val(),
                array: $('#array').val(),
                riddle: $('#riddle').val()
            },
            function (data) {
                if (data.success) {
                    let sakura = parseInt(document.getElementById('points').innerHTML) + 10;
                    $('#points').html(sakura);
                    value = 100 - data.success.array.length / 0.2
                    changeRiddle(data.success.array, data.success.riddle, 1, value);
                } else if (data.failed) {
                    changeRiddle(data.failed.array, data.failed.riddle, 2, value);
                } else {
                    console.log('json', data);
                }
            },
            'json'
        );
        e.preventDefault();
    });
}

$(document).ready(function () {
    $('img.svg').each(function () {
        let $img = jQuery(this);
        let imgID = $img.attr('id');
        let imgClass = $img.attr('class');
        let imgURL = $img.attr('src');

        $.get(imgURL, function (data) {
            let $svg = jQuery(data).find('svg');
            if (typeof imgID !== 'undefined') {
                $svg = $svg.attr('id', imgID);
            }
            if (typeof imgClass !== 'undefined') {
                $svg = $svg.attr('class', imgClass + ' replaced-svg');
            }
            $svg = $svg.removeAttr('xmlns:a');
            $img.replaceWith($svg);
        }, 'xml');
    });

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
                    if (data.startsWith('Success')) {
                        $('#result').html("<p class='text-success'>Bonne réponse !</p>");
                        let sakura = parseInt(document.getElementById('points').innerHTML) + parseInt(data.split(' - ')[1]);
                        $('#points').html(sakura);
                        $('#riddle-value').html(session['riddle']);

                        toast('+' + data.split(' - ')[1]);
                    } else if (data.startsWith('Failed')) {
                        if (session['life'] === 0) {
                            $('#riddle-form').remove();
                            $('#riddle').append("<br/><br/><p class='card-text'>Vous n'avez plus de vie, revenez demain !</p>");
                        } else {
                            $('#result').html("<p class='text-danger'>Dommage, ce n'est pas ça !</p>");
                            $('#life').html(session['life']);
                            $('#riddle-value').html(session['riddle']);
                        }

                        toast('Traduction : ' + data.split(' - ')[1]);
                    } else {
                        console.log(data);
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