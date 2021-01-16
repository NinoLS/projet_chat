<div class="row">
    <aside class="column">
        <div class="side-nav">
            <a class="button bg-secondary border-0 text-white" href="/chat/messages">Retour</a>
            <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id), 'class' => 'button bg-dark border-0 text-white']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="messages view content">
            <h3><?= h($message->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('De') ?></th>
                    <td><?= h($message->user_from) ?></td>
                </tr>
                <tr>
                    <th><?= __('Message') ?></th>
                    <td><?= h($message->message) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($message->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>