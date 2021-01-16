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
                <?php
                echo $this->Form->control('username', ['type' => 'text']);
                echo $this->Form->control('password');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Créer'), ['class' => "bg-success border-0"]) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>