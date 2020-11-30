<?php $title = 'Développeur';
ob_start(); ?>

    <h1 class="font-weight-bold">Développeur :</h1><br/>

    <div class="row">
        <div class="col-md-4">
            <p>Bonjour, je suis actuellement le seul développeur du site, vous pouvez me retrouver ici si vous souhaitez
                me contacter ou juste aller voir par curiosité :</p>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-2">
                    <a href="mailto:orgevalthomas@gmail.com">
                        <i class="fas fa-envelope" style="width: 100%; height: 100%"></i>
                    </a>
                </div>
                <div class="col-2">
                    <a href="https://github.com/ThomasOrgeval" target="_blank">
                        <i class="fab fa-github" style="width: 100%; height: 100%"></i>
                    </a>
                </div>
                <div class="col-2">
                    <a href="https://www.linkedin.com/in/thomas-orgeval/" target="_blank">
                        <i class="fab fa-linkedin" style="width: 100%; height: 100%"></i>
                    </a>
                </div>
                <!--div class="col-2">
                    <a href="https://www.linkedin.com/in/thomas-orgeval/" target="_blank">
                        <i class="fab fa-discord" style="width: 100%; height: 100%"></i>
                    </a>
                </div-->
            </div>
        </div>
    </div>

<?php $content = ob_get_clean();
require('./view/template/template.php'); ?>