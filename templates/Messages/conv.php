<div class="messages index content col-8 mx-auto">
    <h3><?= __("Conversation avec 
                    <span class='text-success'>$friend_with</span>")
        ?></h3>
    <div class="table-responsive">
        <table>
            <tbody>
                <?php
                $max = max(sizeof($messages), sizeof($messages2));
                for ($i = 0; $i < $max; $i++) { ?>
                    <?php if (!empty($messages->skip($i)->first())) { ?>

                        <tr class="float-right">
                            <td><?php echo
                                "<span class='text-dark'>" . $messages->skip($i)->first()->message . "</td></span>"
                                    .
                                    "<td><span class='text-dark'>" .  $messages->skip($i)->first()->created . "</span>"; ?></td>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (!empty($messages2->skip($i)->first())) { ?>
                        <tr>
                            <td><?php echo
                                "<span class='text-dark mx-5'>" . $messages2->skip($i)->first()->created . "</span></td>"
                                    .
                                    "<td><span class='text-success mx-5'>" . $messages2->skip($i)->first()->message . "</span>"; ?></td>
                        </tr>
                    <?php } ?>
                <?php
                }

                /*  foreach ($messages as $message) : ?>
                   
                    <tr>
                        <td><?php echo
                            "<span class='text-dark mx-5'>" . $message2->created . "</span>"
                                .
                                "<span class='text-dark mx-5'>" . $message2->message . "</span>"; ?></td>
                    </tr>
                <?php endforeach;   */ ?>
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