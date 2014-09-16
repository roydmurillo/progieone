<!-- additional scripts -->
<style>

    .iteminfo{border:1px solid rgba(0,0,0,0.3); background:#FFF; }
    .image_holder{ border:1px solid rgba(0,0,0,0.4); }
    .item_price{margin-top: 0px !important; margin-left: 23px; text-align:left; font-size: 17px; color:#405E9C; font-family:arial; font-weight:bold}
    .item_posted{float:left; font-family:tahoma; clear:both; width:90%; margin-top: 0px !important; margin-left: 23px; margin-bottom:5px; text-align:left; font-size: 10px; color:#777;}
    .item_seller{ width:189px;}
    .inner_seller{ float:left; margin:3px 0px 0px 12px; font-size:12px; font-weight:bold; color:#333;}
    .item_title{margin-top:0px !important; height:48px; color:#333; width:143px; text-align:left; margin-top:-10px; margin-left:18px; font-weight:bold; text-transform:none !important;}
    .add_wishlist{margin: 3px 0px 0px 23px;}
</style>

<script type="text/javascript" src="<?php echo base_url(); ?>scripts/itemlist_scripts.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security");
$this->load->module("function_country");
$type_initial = $this->function_security->encode("ajax_wishlist"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url() . $type_initial; ?>">

<div class="title_bar" style="position:relative;">
    FEATURED WATCHES
    <a href="<?php echo base_url() ?>all-watches" style="position:absolute; color:#405E9C; font-family:verdana; border:0px; border:none; font-size:12px; right:12px; top:0px">View All</a>
</div>
<!-- item lists here -->
<div class="item_list_watches">

    <?php
    // ============================================================
    // load items
    // ============================================================
    if(!empty($item_list)){

        $user_id = unserialize($this->native_session->get("user_info"));
        $user = $user_id["user_id"];

        foreach($item_list as $featured){
            //set link
            $item_id = $featured->item_id;
            $link = "unisex-watches";
            if($featured->item_gender == 1){
                $link = "mens-watches";
            } elseif($featured->item_gender == 2){
                $link = "womens-watches";
            }
            $nam = str_replace(" ","-",(trim($featured->item_name)));
            $nam = str_replace('&#47;','-',$nam);
            $nam = str_replace('&amp;#47;','-',$nam);

            $url =  base_url() .$link ."/". $nam ."_watch_i" .$this->function_security->r_encode($item_id) . ".html";
            $price = $featured->item_price;

            //get primary image
            $images = unserialize($featured->item_images);
            $count = count($images) - 1;
            $rand = rand(0,$count);
            @$primary = $images[$rand];

            // when primary image has accidentally uploaded image error
            // to prevent displaying no image if there are other image available
            if(count($images) > 0 && $primary == "" && is_array($images)){
                foreach($images as $i){
                    if(trim($i) != ""){
                        $primary = $i;
                        break;
                    }
                }
            }

            //if no image
            if($primary == ""){
                $primary = base_url() . "assets/images/no-image.png";
            } else {
                if(strpos($primary,"localhost") > -1){
                    $primary = explode(".",$primary);
                    $primary = $primary[0] . "_thumb." . $primary[1];
                } else {
                    $primary = explode(".",$primary);
                    $primary = $primary[0] ."." . $primary[1] . "_thumb." . $primary[2];
                }
            }

            //country
            $data = ($this->function_users->get_user_fields_by_id(array("user_name", "user_country","user_activated"), $featured->item_user_id));

            if($data["user_activated"] != "deactivated"){
                ?>

                <div class="iteminfo">
                    <div class="item_seller">
                        <div class="inner_seller">
                            <table>
                                <tr>
                                    <td><div class="fright" style="margin-right:5px">Seller :</div></td>
                                    <td> <a href="<?php echo base_url(); ?>member_profile/<?php echo $data["user_name"]; ?>"><?php echo $data["user_name"]; ?></a></td>
                                </tr>
                                <tr>
                                    <td><div class="fright" style="margin-right:5px">Rating :</div></td>
                                    <td><?php $this->function_rating->get_stars($featured->item_user_id); ?></td>
                                </tr>
                                <tr>
                                    <td><div class="fright" style="margin-right:5px">Country :</div></td>
                                    <td><div class="flag flag-<?php echo strtolower($data["user_country"]); ?>" title="<?php echo $this->function_country->get_country_name($data["user_country"]); ?>"></div></td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <a href="<?php echo $url; ?>" class="a_class">
                        <div class="image_holder">
                            <img alt="<?php echo $featured->item_name; ?>" src="<?php echo $primary; ?>" />
                        </div>
                    </a>
                    <a href="<?php echo $url; ?>" class="item_title">
                        <?php
                        if(strlen(trim($featured->item_name)) > 35){
                            $n = substr(ucwords(strtolower($featured->item_name)),0,45) ."...";
                        } else {
                            $n = substr(ucwords(strtolower($featured->item_name)),0,45);
                        }
                        echo $n;
                        ?>
                    </a>
                    <div class="item_price"><?php echo $this->function_currency->format($price); ?></div>
                    <input type="hidden" class="item" value="<?php echo $this->function_security->r_encode($featured->item_id); ?>">
                    <?php
                    if($this->function_login->is_user_loggedin()){
                        if($this->template_itemlist->not_exist_wishlist($user,$item_id)){
                            echo '<a href="javascript:;" class="add_wishlist">Add to Watchlist</a>';
                        } else {
                            echo '<a href="javascript:;" class="add_wishlist">In Watchlist</a>';
                        }
                    } else {
                        echo '<a href="javascript:;" class="add_wishlist">Add to Watchlist</a>';
                    }
                    ?>
                </div>

            <?php
            }
        }

    }

    ?>



</div>
