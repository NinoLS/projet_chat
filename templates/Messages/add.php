<div class="row">
    <div class="column-responsive column-80">
        <div class="messages form content">
            <h3><?= __('Nouveau message') ?></h3>
            <?= $this->Form->create($message) ?>
            <fieldset>
                <?php
                //echo $this->Form->control('user_from');
                echo $this->Form->control('user_to');
                echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Envoyer')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>