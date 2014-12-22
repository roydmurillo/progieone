<?php
    if($data){
        foreach ($data as $nkey1 => $fields){

    ?>
            <tr>
                <td><?php echo ucfirst($fields['user_fname']).' '. ucfirst($fields['user_lname']);?></td>
                <td><?php echo ucfirst($fields['user_name'])?></td>
                <td><?php echo ucfirst($fields['user_email'])?></td>
                <td>
                    <input type="hidden" id="userid<?php echo $fields['user_id']?>" class="paypal_price" data-userid="<?php echo $fields['user_id']?>" data-listid="<?php echo $fields['user_listprice_id']?>" value="<?php echo $fields['paypal_price']?>">
                    <a href="Javascript:;" class="userpaypal" id="userpaypal<?php echo $fields['user_id']?>" data-bond="<?php echo $fields['user_id']?>">price</a>
                    <a href="Javascript:;" class="userdelete" id="userdelete<?php echo $fields['user_id']?>" data-bond="<?php echo $fields['user_id']?>"> | delete</a>
                </td>
                <td><label id="user_price<?php echo $fields['user_id']?>"><?php echo $fields['paypal_price']?></label></td>
            </tr>
    <?php
        }
    }
    else{
    ?>
        <tr>
            <td colspan="5">no record(s) found.</td>
        </tr>
    <?php
    }
    ?> 