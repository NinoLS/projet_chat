<nav class="nav justify-content-center mb-5">
    <a href="/chat/" class="button bg-success border-0 text-white col-2 mx-2">Conversations</a>
    <a href="/chat/friends" class="button bg-secondary border-0 text-white col-2 mx-2">Amis</a>
    <a href="/chat/messages" class="button bg-secondary border-0 text-white col-2 mx-2">Messages récents</a>
    <a href="/chat/users/logout" class="button bg-dark border-0 text-white col-2 mx-2">Déconnexion</a>
</nav>
<div class="messages index content col-8 mx-auto">
    <h3><?= __('Conversations') ?><a class="button bg-info border-0 text-white float-right" href="/chat/users/edit/<?= $user ?>">Moi</a></h3>
        <div class="table-responsive" style="overflow: scroll; max-height:30em;">
        <table>
            <tbody>
                <?php foreach ($conversations as $conv) : ?>
                    <tr>
                        <td><a href="/chat/messages/add/<?= h($conv->friend_with) ?>"><span class="text-success font-normal"><?= h($conv->friend_with) ?></span></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>