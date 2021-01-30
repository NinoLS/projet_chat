<?php 
    $key = "toutaunefinsauflasaucissequienadeux01012021";
    $methods = openssl_get_cipher_methods();
?>
<nav class="nav justify-content-center mb-5">
    <a href="/chat/" class="button bg-success border-0 text-white col-2 mx-2">Conversations</a>
    <a href="/chat/friends" class="button bg-secondary border-0 text-white col-2 mx-2">Amis</a>
    <a href="/chat/messages" class="button bg-secondary border-0 text-white col-2 mx-2">Messages récents</a>
    <a href="/chat/users/logout" class="button bg-dark border-0 text-white col-2 mx-2">Déconnexion</a>
</nav>
<div class="messages index content">
    <h3><?= __('Messages récents') ?></h3>
    <div class="table-responsive" style="overflow: scroll; max-height:30em;">
        <table>
            <thead>
                <tr>
                    <th><?= __('De') ?></th>
                    <th><?= __('À') ?></th>
                    <th><?= __('Message') ?></th>
                    <th><?= __('Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message) : ?>
                    <tr>
                        <td><?= h($message->user_from) ?></td>
                        <td><?= h($message->user_to) ?></td>
                        <td><?= openssl_decrypt($message->message,$methods[64],$key) ?></td>
                        <td><?= h($message->created) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Voir'), ['action' => 'view', $message->id], ['class' => 'text-info']) ?>
                            <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $message->id], ['class' => 'text-dark']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>