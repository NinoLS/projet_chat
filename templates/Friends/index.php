<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Friend[]|\Cake\Collection\CollectionInterface $friends
 */
?>
<div class="friends index content">
    <h3><?= __('Friends') ?></h3>
    <?= $this->Html->link(__('Nouveau'), ['action' => 'add'], ['class' => 'button float-left']) ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Ami') ?></th>
                    <th><?= $this->Paginator->sort('Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($friends as $friend) : ?>
                    <tr>
                        <td><?= h($friend->friend_with) ?></td>
                        <td><?= h($friend->created) ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $friend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $friend->id)]) ?>
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


<!-- 
<div class="friends index content mt-5">
    <h3><?= __('Demandes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('Nom') ?></th>
                    <th><?= $this->Paginator->sort('Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requested_friends as $requested_friend) : ?>
                    <tr>
                        <td><?= h($requested_friend->username) ?></td>
                        <td><?= h($requested_friend->created) ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $requested_friend->id], ['confirm' => __('Are you sure you want to delete # {0}?', $requested_friend->id)]) ?>
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
 
<?php

echo "friends<br/>";
print_r($friends);
echo "<br/><br/>R_friends<br/>";
print_r($requested_friends);
?> -->