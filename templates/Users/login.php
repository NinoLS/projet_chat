<aside class="column">
    <div class="side-nav">
        <a href="/chat/users/add" class="button bg-info border-0 text-white">Sign in</a>
    </div>
</aside>
<div class="row">
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Flash->render() ?>
            <h3>Connexion</h3>
            <?= $this->Form->create() ?>
            <fieldset>
                <!-- <legend><?= __("Veuillez s'il vous plaît entrer votre nom d'utilisateur et votre mot de passe") ?></legend> -->
                <?= $this->Form->control('username', ['required' => true,'label' => 'Pseudo']) ?>
                <?= $this->Form->control('password', ['required' => true,'label' => 'Mot de passe']) ?>
            </fieldset>
            <?= $this->Form->submit(__('Login'), ['class' => 'bg-success border-0']); ?>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script>
    $(function() {
        $("#username").blur(verif_username);
        $("#password").blur(verif_password);

        $("#send_button").click(function() {
            if (verif_username() & verif_password()) {
                return true;
            } else return false;
        })
    });

    function verif_username() {
        let username = $("#username").val().trim();
        if (!username) {
            $("#username").addClass("border-danger text-danger");
        } else {
            $("#username").removeClass("border-danger text-danger");
        }
    }

    function verif_password() {
        let password = $("#password").val();
        if (!password) {
            $("#password").addClass("border-danger text-danger");
        } else {
            $("#password").removeClass("border-danger text-danger");
        }
    }
</script>