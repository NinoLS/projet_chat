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
                <?= $this->Form->control('username', ['required' => true]) ?>
                <?= $this->Form->control('password', ['required' => true]) ?>
            </fieldset>
            <?= $this->Form->submit(__('Login'), ['class' => 'bg-success border-0']); ?>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>