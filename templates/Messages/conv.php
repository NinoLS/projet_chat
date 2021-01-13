<div class="messages index content col-8 mx-auto">
    <h3><?= __("Conversation $friend_with") ?></h3>
    <div class="table-responsive">
        <table>
            <tbody>
                <?php foreach ($messages as $message) : ?>
                    <tr>
                        <td><?php print_r($message) ;?></td>
                        <!--<a href="/chat/friends/conv/<?= h($message->message) ?>"><?= h($conv->friend_with) ?></a>-->
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