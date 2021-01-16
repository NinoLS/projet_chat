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
                <legend><?= __('Edit User') ?></legend>
                <?php
                echo $this->Form->control('username');
                echo $this->Form->control('password');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit'), ['class' => 'bg-success border-0 ']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>