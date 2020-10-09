<?php

function flash()
{
    if (isset($_SESSION['Flash'])) {
        extract($_SESSION['Flash']);
        unset($_SESSION['Flash']);
        return "<script>
                    $(document).ready(function ()) {
                        $('toast').toast('show')
                    }
                </script>

                <div class='toast alert alert-$type' id='toast' style='position: absolute; top: 80px; right: 50px;'>
                    <div class='toast-header'>
                        <strong class='mr-auto'><i class='fa fa-book'></i> $message</strong>
                    </div>
                    <!--div class='toast-body'></div-->
                </div>";
    }
}

function setFlash($message, $type = 'success')
{
    $_SESSION['Flash']['message'] = $message;
    $_SESSION['Flash']['type'] = $type;
}
