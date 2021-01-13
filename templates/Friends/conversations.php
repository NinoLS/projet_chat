<div class="messages index content col-8 mx-auto">
    <h3><?= __('Conversations') ?></h3>
    <div class="table-responsive">
        <table>
            <tbody>
                <?php foreach ($conversations as $conv) : ?>
                    <tr>
                        <td><a href="/chat/messages/conv/<?= h($conv->friend_with) ?>"><?= h($conv->friend_with) ?></a></td>
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