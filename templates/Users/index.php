<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users index content">
    <h3><?= __('Users') ?></h3>
    <?= $this->Html->link(__('Nouveau'), ['action' => 'add'], ['class' => 'button bg-success border-0 float-left']) ?>
    <div class="table-responsive" style="overflow: scroll; height:30em;">
        <table>
            <thead>
                <tr>
                    <th><?= __('Username') ?></th>
                    <th><?= __('Password') ?></th>
                    <th><?= __('Created') ?></th>
                    <th><?= __('Modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= h($user->username) ?></td>
                        <td><?= h($user->password) ?></td>
                        <td><?= h($user->created) ?></td>
                        <td><?= h($user->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $user->username]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->username]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->username], ['confirm' => __('Supprimer le compte de {0}?', $user->username)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>