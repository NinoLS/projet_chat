<div class="messages index content col-8 mx-auto">
    <h3><?= __("Conversation avec 
                    <span class='text-success'>$friend_with</span>")
        ?></h3>
    <div class="table-responsive">
        <table>
            <tbody>
                <?php
                $i = 0;
                foreach ($messages as $message) { ?>
                    <tr>
                        <td class="col-5">
                            <?php
                            if ($messages->skip($i)->first()->user_from == $friend_with) {
                                echo "<span class='text-dark'>";
                            } else echo "<span class='text-success float-right mr-5'>";
                            ?>
                            <?= $messages->skip($i)->first()->message ?></span>
                        </td>
                        <td class="col-3">
                            <span class='text-dark'> <?= $messages->skip($i)->first()->created ?></span>
                        </td>
                    </tr>

                <?php $i++;
                } ?>
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