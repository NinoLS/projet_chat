<nav class="nav justify-content-center mb-5">
    <a href="/chat/friends" class="button text-white col-3 mx-2">Amis</a>
    <a href="/chat/messages" class="button text-white col-3 mx-2">Messages récents</a>
    <a href="/chat/users/logout" class="button text-white col-3 mx-2">Déconnexion</a>
</nav>
<div class="messages index content">
    <h3><?= __('Messages récents') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('De') ?></th>
                    <th><?= $this->Paginator->sort('À') ?></th>
                    <th><?= $this->Paginator->sort('message') ?></th>
                    <th><?= $this->Paginator->sort('Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message) : ?>
                    <tr>
                        <td><?= h($message->user_from) ?></td>
                        <td><?= h($message->user_to) ?></td>
                        <td><?= h($message->message) ?></td>
                        <td><?= h($message->created) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Voir'), ['action' => 'view', $message->id]) ?>
                            <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $message->id], ['confirm' => __('Supprimer le message de {0}?', $message->user_from)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator mt-5">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('première')) ?>
            <?= $this->Paginator->prev('< ' . __('précédent')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('suivant') . ' >') ?>
            <?= $this->Paginator->last(__('dernière') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} de {{pages}}, total: {{count}}')) ?></p>
    </div>
</div>