<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <a class="button bg-secondary border-0 text-white" href="/chat/users">Retour</a>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <h3><?= __('Editer compte') ?></h3>
                <?= $this->Form->control('password') ?>
                <ul id="error_password" class="mb-5 d-none">
                    <li>8 caractères minimum</li>
                    <li>Une lettre minimum</li>
                    <li>Un chiffre minimum</li>
                </ul>
                <?= $this->Form->control('Confirm Password',['type' => 'password','id' => "confirm_password"]) ?>
                <ul id="error_confirm_password" class="mb-5 d-none">
                    <li>Le mot de passe ne correspond pas.</li>
                </ul>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'bg-success border-0 ','id' => "send_button"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(function() {
        $("#password").blur(verif_password);
        $("#confirm_password").keyup(verif_confirm_password);
        
        //si on a modifié les 2 champs
        //action sur password => verif sur password & confirm_password
        $("#password").blur(function(){
            if($("#password").val().length > 0 && $("#confirm_password").val().length > 0)
                verif_confirm_password();
        });





        $("#send_button").click(function() {
            if (verif_username() & verif_password() & verif_confirm_password()) {
                return true;
            } else return false;
        })
    });

    function verif_password() {
        let password = $("#password").val();
        if (!password || !password.match(/[0-9]/) || !password.match(/[A-Za-z]/)) {
            $("#password").addClass("border-danger text-danger");
            $("#error_password").removeClass("d-none");
            return false;
        } else {
            $("#password").removeClass("border-danger text-danger");
            $("#error_password").addClass("d-none");
            return true;
        }
    }

    function verif_confirm_password() {
        let password = $("#password").val();
        let confirm_password = $("#confirm_password").val();
        if (confirm_password != password){
            $("#confirm_password").addClass("border-danger text-danger");
            $("#error_confirm_password").removeClass("d-none");
            return false;
        } else {
            $("#confirm_password").removeClass("border-danger text-danger");
            $("#error_confirm_password").addClass("d-none");
            return true;
        }
    }
</script>