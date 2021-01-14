<div class="row">
    <div class="column-responsive column-80">
        <div class="friends form content">
            <h3><?= __('Nouvel ami') ?></h3>
            <?= $this->Form->create($friend) ?>
            <fieldset>
                <?php
                //echo $this->Form->control('username');
                echo $this->Form->control('friend_with');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Envoyer')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>