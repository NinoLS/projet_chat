<nav class="nav justify-content-center mb-5">
    <a href="/chat/friends" class="button bg-success border-0 text-white col-3 mx-2">Amis</a>
    <a href="/chat/messages" class="button bg-secondary border-0 text-white col-3 mx-2">Messages récents</a>
    <a href="/chat/users/logout" class="button bg-secondary border-0 text-white col-3 mx-2">Déconnexion</a>
</nav>
<!--MES AMIS-->
<div class="friends index content">
    <h3><?= __('Amis') ?></h3>
    <?= $this->Html->link(__('Nouveau'), ['action' => 'add'], ['class' => 'button bg-success border-0 float-left']) ?>
    <div class="table-responsive" style="overflow: scroll; max-height:30em;">
        <table>
            <thead>
                <tr>
                    <th><?= __('Ami') ?></th>
                    <th><?= __('Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($friends as $friend) : ?>
                    <tr>
                        <td><?= h($friend->friend_with) ?></td>
                        <td><?= h($friend->created) ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $friend->id], ['confirm' => __('Supprimer {0} de vos amis?', ucfirst($friend->friend_with)), 'class' => 'text-dark']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!--MES AJOUTS EN ATTENTES-->
<div class="friends index content mt-5">
    <h3><?= __('Vous les avez ajouté') ?></h3>
    <div class="table-responsive" style="overflow: scroll; max-height:12em;">
        <table>
            <thead>
                <tr>
                    <th><?= __('Nom') ?></th>
                    <th><?= __('Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users_i_added as $request) : ?>
                    <tr>
                        <td><?= h($request->friend_with) ?></td>
                        <td><?= h($request->created) ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Annuler'), ['action' => 'delete', $request->id], ['confirm' => __("Annuler votre demande d'ami pour {0}?", ucfirst($request->friend_with)), 'class' => 'text-dark']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!--MES DEMANDES-->
<div class="friends index content mt-5">
    <h3><?= __('Ils vous ont ajouté') ?></h3>
    <div class="table-responsive" style="overflow: scroll; max-height:12em;">
        <table>
            <thead>
                <tr>
                    <th><?= __('Nom') ?></th>
                    <th><?= __('Date') ?></th>
                    <th class=" actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users_added_me as $request) : ?>
                    <tr>
                        <td><?= h($request->username) ?></td>
                        <td><?= h($request->created) ?></td>
                        <td class="actions">
                            <?= $this->Form->postLink(__('Accepter'), ['action' => 'add'], ['data' => ['friend_with' => $request->username], 'class' => 'text-info']) ?>
                            <?= $this->Form->postLink(__('Refuser'), ['action' => 'delete', $request->id], ['confirm' => __("Refuser la demande d'ami de {0}?", ucfirst($request->username)), 'class' => 'text-dark']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>