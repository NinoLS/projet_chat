<aside>
    <a class="button bg-secondary border-0 text-white float-left" href="/chat/messages">Retour</a>  
</aside>
<div class="messages index content col-9 mx-auto">
    <h3><?= __("Conversation avec 
                    <span class='text-success'>$friend_with</span>")
        ?></h3>
    <?= $this->Form->create($message) ?>
    <div class="table-responsive" id="scroll_div" style="overflow: scroll; max-height:25em;">
        <table class="table" width="100%">
            <tbody>
                <?php
                $i = 0;
                foreach ($all_messages as $message) { ?>
                    <tr scope="row">
                        <?php
                        if ($all_messages->skip($i)->first()->user_from == $friend_with) {
                            echo "<td width='40%'><span class='text-success float-left ml-5 px-3 py-1 table-success'>";
                            echo $all_messages->skip($i)->first()->message;
                            echo "</span></td><td width='40%'></td>";
                        } else {
                            echo "<td width='40%'></td><td width='40%'><span class='text-dark float-right mr-5 px-3 py-1 table-secondary'>";
                            echo $all_messages->skip($i)->first()->message;
                            echo "</span></td>";
                        }
                        ?>
                        <td class="">
                            <span class='text-dark'> <?= $all_messages->skip($i)->first()->created ?></span>
                        </td>
                    </tr>

                <?php $i++;
                } ?>
            </tbody>
        </table>
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
    </div>
</div>
<script type="text/javascript">
    let scroll_div = document.getElementById('scroll_div');
    scroll_div.scrollTop = scroll_div.scrollHeight;

    let input_message = document.getElementById("message").focus();
</script>