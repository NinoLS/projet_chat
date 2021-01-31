<?php 
    $key = "toutaunefinsauflasaucissequienadeux01012021";
    $methods = openssl_get_cipher_methods();
?>
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
                    echo '<p class="text-success table-success px-3 py-1 float-left"">' . openssl_decrypt($all_messages->skip($i)->first()->message,$methods[64],$key) . "</p>";
                    echo '</div><div class="col-5"></div>';
                } else {
                    echo '<div class="col-5"></div><div class="col-5">';
                    echo '<p class="text-dark table-secondary px-3 py-1 float-right">' . openssl_decrypt($all_messages->skip($i)->first()->message,$methods[64],$key) . "</p>";
                    echo '</div>';
                }
                echo '<div class="col-2">';


                //DATE & HEURE
                $date = $all_messages->skip($i)->first()->created;
                $tmp_time = explode(',',$date); //on sépare heure & date
                $tmp_hour = explode(":",$tmp_time[1]); //on sépare heures & minutes

                if(strpos($tmp_time[1],'PM') != false) //si PM => +12h sur les heures
                    $tmp_hour[0] += 12;

                $tmp_time = explode("/",$tmp_time[0]); //on sépare jour,mois,année
                echo '<p class="text-dark mt-1">' . $tmp_time[1]."/".$tmp_time[0].", ".$tmp_hour[0].":".substr($tmp_hour[1],0,strlen($tmp_hour[1])-3) . '</p>'; //-3 : "_PM" enlevé
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