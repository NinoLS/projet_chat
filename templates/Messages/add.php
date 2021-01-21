<div class="row">
    <div class="messages index content col-10 mx-auto">
        <h3><?= __("Conversation avec 
                    <span class='text-success'>$friend_with</span>")
            ?></h3>
        <?= $this->Form->create($message) ?>
        <div class="container" id="scroll_div" style="overflow: scroll; max-height:25em;">
            <?php
            $i = 0;
            foreach ($all_messages as $message) {
                echo '<div class="row mt-1">';
                if ($all_messages->skip($i)->first()->user_from == $friend_with) {
                    echo '<div class="col-5">';
                    echo '<p class="text-success table-success px-3 py-1 float-left"">' . $all_messages->skip($i)->first()->message . "</p>";
                    echo '</div><div class="col-5"></div>';
                } else {
                    echo '<div class="col-5"></div><div class="col-5">';
                    echo '<p class="text-dark table-secondary px-3 py-1 float-right">' . $all_messages->skip($i)->first()->message . "</p>";
                    echo '</div>';
                }
                echo '<div class="col-2">';
                echo '<p class="text-dark">' . $all_messages->skip($i)->first()->created . '</p>';
                echo '</div></div>';
                $i++;
            } ?>
        </div>
        <div class="messages form content">
            <fieldset>
                <?php
                //echo $this->Form->control('user_from');
                //echo $this->Form->control('user_to');
                echo $this->Form->control('message', ['label' => '']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Envoyer'), ['class' => 'bg-success border-0']) ?>
            <?= $this->Form->end() ?>
            <a class="button bg-secondary border-0 text-white" href="/chat/messages">Retour</a>

        </div>
    </div>
</div>
<script type="text/javascript">
    let scroll_div = document.getElementById('scroll_div');
    scroll_div.scrollTop = scroll_div.scrollHeight;

    let input_message = document.getElementById("message").focus();
</script>