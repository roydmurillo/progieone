<!-- additional scripts -->

<script type="text/javascript" src="<?php echo base_url(); ?>scripts/itemlist_scripts.js"></script>

<!-- content goes here -->
<?php $this->load->module("function_security");
$this->load->module("function_country");
$type_initial = $this->function_security->encode("ajax_wishlist"); ?>
<input id="load_initial" type="hidden" value="<?php echo base_url() . $type_initial; ?>">

<div class="heading-bar row">
    <div class="col-md-6">FEATURED WATCHES</div>
    <div class="col-md-6 text-right"><a href="<?php echo base_url() ?>all-watches">View All</a></div>
</div>
<!-- item lists here -->
<div class="row">
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
//            $images = unserialize($featured->item_images);
//            $count = count($images) - 1;
//            $rand = rand(0,$count);
//            @$primary = $images[$rand];

            // when primary image has accidentally uploaded image error
            // to prevent displaying no image if there are other image available
//            if(count($images) > 0 && $primary == "" && is_array($images)){
//                foreach($images as $i){
//                    if(trim($i) != ""){
//                        $primary = $i;
//                        break;
//                    }
//                }
//            }

            //if no image
//            if($primary == ""){
//                $primary = base_url() . "assets/images/no-image.png";
//            } else {
//                if(strpos($primary,"localhost") > -1){
//                    $primary = explode(".",$primary);
//                    $primary = $primary[0] . "_thumb." . $primary[1];
//                } else {
//                    $primary = explode(".",$primary);
//                    $primary = $primary[0] ."." . $primary[1] . "_thumb." . $primary[2];
//                }
//            }
            
            $new_images = unserialize($featured->item_images);
            $no_image = base_url() . "assets/images/no-image.png";
            $default_image = $no_image;
            if(is_array($new_images)){
                foreach ($new_images as $xx){
                    if($xx[0] == 1){
                        $default_image = $xx[1];
                    }

                    if($default_image == $no_image){
                        $default_image = $xx[1];
                    }
                    else{
                        if(strpos($default_image,"localhost") > -1){
                            $default_image = explode(".",$default_image);
                            $default_image = $default_image[0] . "_thumb." . $default_image[1];
                        } else {
                            $default_image = explode(".",$default_image);
                            $default_image = $default_image[0] ."." . $default_image[1] . "_thumb." . $default_image[2];
                        }
                    }
                }
            }

            //country
            $data = ($this->function_users->get_user_fields_by_id(array("user_name", "user_country","user_activated"), $featured->item_user_id));

            if($data["user_activated"] != "deactivated"){
                ?>

                <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3 item">
                    <figure class="thumbnail">
                        <a href="<?php echo $url; ?>">
                            <?php
                                $new_images = unserialize($featured->item_images);
                                $no_image = base_url() . "assets/images/no-image.png";
                                $default_image = $no_image;
                                if(is_array($new_images)){
                                    foreach ($new_images as $xx){
                                        if($xx[0] == 1){
                                            $default_image = $xx[1];
                                        }

                                        if($default_image == $no_image){
                                            $default_image = $xx[1];
                                        }
                                    }
                                }
                            ?>
                            <img alt="<?php echo $featured->item_name; ?>" src="<?php echo $default_image; ?>" />
                        </a>
                        <h5 class="text-center"><a class="name" href="<?php echo base_url(); ?>member_profile/<?php echo $data["user_name"]; ?>"><?php echo $data["user_name"]; ?></a></h5>
                            <figcaption class="caption">
                            <a class="title" href="<?php echo $url; ?>">
                                <?php
                                if(strlen(trim($featured->item_name)) > 35){
                                    $n = substr(ucwords(strtolower($featured->item_name)),0,45) ."...";
                                } else {
                                    $n = substr(ucwords(strtolower($featured->item_name)),0,45);
                                }
                                echo $n;
                                ?>
                                </a>
                            <div class="clearfix">
                                <div class="pull-left"><?php echo $this->function_currency->format($price); ?></div>
                                <input type="hidden" value="<?php echo $this->function_security->r_encode($featured->item_id); ?>">
                                <div class="pull-right"><?php
                                if($this->function_login->is_user_loggedin()){
                                    if($this->template_itemlist->not_exist_wishlist($user,$item_id)){
                                        echo '<a href="javascript:;" class="btn btn-primary">Add to Watchlist</a>';
                                    } else {
                                        echo '<a href="javascript:;" class="btn btn-primary">In Watchlist</a>';
                                    }
                                } else {
                                    echo '<a href="javascript:;" class="btn btn-primary">Add to Watchlist</a>';
                                }
                                ?></div>
                            </div>
                            </figcaption>
                    </figure>
                </div>

            <?php
            }
        }
    }
    ?>
</div>
