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
                $('#uncheck').attr('id', 'check').attr('src', './resources/svgs/check.svg');
            } else if(data === 'REMOVE') {
                $('#check').attr('id', 'uncheck').attr('src', './resources/svgs/uncheck.svg');
            }
        },
        'html'
    );
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