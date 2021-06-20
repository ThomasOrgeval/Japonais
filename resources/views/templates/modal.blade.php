<div class="modal fade" id="connect" tabindex="-1" aria-labelledby="connect" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-4">
                <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="mdb-tab-login" data-mdb-toggle="pill" href="#pills-login"
                           role="tab" aria-controls="pills-login" aria-selected="true">Connexion</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="mdb-tab-register" data-mdb-toggle="pill" href="#pills-register"
                           role="tab" aria-controls="pills-register" aria-selected="false">Créer mon compte</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="pills-login" role="tabpanel"
                         aria-labelledby="mdb-tab-login">
                        <form method="post" action="{{ route('login') }}">
                            @csrf
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="loginMail" name="mail"
                                       class="form-control" required>
                                <label class="form-label" for="loginMail">Email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="loginPassword" name="pass"
                                       class="form-control" required>
                                <label class="form-label" for="loginPassword">Mot de passe</label>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4">Connexion</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="mdb-tab-register">
                        <form method="post" action="{{ route('signUp') }}">
                            @csrf
                            <!-- Pseudo input -->
                            <div class="form-outline mb-4">
                                <input type="text" id="registerPseudo" name="pseudo"
                                       class="form-control" required>
                                <label class="form-label" for="registerPseudo">Pseudo</label>
                            </div>
                            <!-- Email input -->
                            <div class="form-outline mb-4">
                                <input type="email" id="registerEmail" name="mail"
                                       class="form-control" required>
                                <label class="form-label" for="registerEmail">Adresse mail</label>
                            </div>
                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" id="registerPassword" name="pass" autocomplete="new-password"
                                       class="form-control" minlength="8" required>
                                <label class="form-label" for="registerPassword">Mot de passe (8 caractères au
                                    minimum)</label>
                            </div>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-1">Connexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
