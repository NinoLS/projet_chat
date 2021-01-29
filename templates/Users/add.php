<aside class="column">
    <div class="side-nav">
        <a class="button bg-secondary border-0 text-white" href="/chat/users">Retour</a>
    </div>
</aside>
<div class="row">
    <div class="column-responsive column-80">
        <div class="users form content">
            <h3><?= __('Nouvel utilisateur') ?></h3>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <?= $this->Form->control('username', ['type' => 'text']) ?>
                <ul id="error_username" class="mb-5 d-none">
                    <li>8-20 caractères</li>
                    <li>Chiffres, lettres, tirets</li>
                    <li>Pas d'espace</li>
                </ul>
                <?= $this->Form->control('password') ?>
                <ul id="error_password" class="mb-5 d-none">
                    <li>8-20 caractères</li>
                    <li>Chiffres, lettres, tirets</li>
                    <li>Pas d'espace</li>
                </ul>
            </fieldset>
            <?= $this->Form->button(__('Créer'), ['class' => "bg-success border-0"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(function() {
        $("#username").blur(verif_username);
        $("#password").blur(verif_password);
    });

    //VERIF GLOBALE : 
    /* compte classe error (pas ouf)  
    /* verif de tout <=> appel de toutes les fonctions
    */

    function verif_username() {
        let username = $("#username").val().trim();
        if (username.length < 8 || username.length > 20 || !username.match(/^[A-Za-z0-9_-]*$/)) {
            $("#username").addClass("border-danger text-danger");
            $("#error_username").removeClass("d-none");
        } else {
            $("#username").removeClass("border-danger text-danger");
            $("#error_username").addClass("d-none");
        }
    }

    function verif_password() {
    }
</script>