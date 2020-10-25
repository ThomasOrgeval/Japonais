<?php

function flash()
{
    if (isset($_SESSION['Flash'])) {
        $flash = "<script>
                    $(document).ready(function ()) {
                        $('toast').toast('show')
                    }
                </script>

                <div class='toast alert alert-".$_SESSION['Flash']['type']."' id='toast' style='position: absolute; top: 80px; right: 50px; opacity: 0.8;'>
                    <div class='toast-header'>
                        <strong class='mr-auto'><i class='fa fa-book'></i> ".$_SESSION['Flash']['message']."</strong>
                    </div>
                    <!--div class='toast-body'></div-->
                </div>";
        unset($_SESSION['Flash']);
        return $flash;
    }
}

function setFlash($message, $type = 'success')
{
    $_SESSION['Flash']['message'] = $message;
    $_SESSION['Flash']['type'] = $type;
}
