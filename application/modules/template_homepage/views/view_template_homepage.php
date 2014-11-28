<!-- content goes here -->
<div class="homepage">
		

    <div class="container">
        <div class="ww-tab-container">
            <?php
                $this->load->module("function_login");
                if($this->function_login->is_user_loggedin()){
            ?>
                   <form method="GET" action="<?php echo base_url('search');?>">
                       <div class="home-search form-group">
                           <div class="input-group">
                               <input type="text" name="s" class="form-control" placeholder="type in keyword here...">
                               <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div> 
                           </div>
                       </div>
                   </form>
                   <div class="container text-center" style="margin-bottom: 24px;">
                    <h4>Search watches from A - Z</h4>
                </div>
            <?php
                }
            ?>
            
            <div class="ww-tab-panel active" id="buy">
             <?php
                $this->load->module("function_login");
                if(!$this->function_login->is_user_loggedin()){
            ?>
                <div class="container text-center">
                    <h2>We love watches so much we can't stop looking at them</h2>
                    <h4>Search for all kinds and types of watch from other cyberwatchcafe users</h4>
                </div>
            <?php
                }
            ?>
                <?php
                //item listings
                $this->load->module('template_itemlist');
                $this->template_itemlist->view_template_itemlist(); 
                ?>   
            </div>
            <div class="ww-tab-panel container text-center" id="sell">
                    <h2>Sell any watches, pocketwatches and clocks...</h2>
                    <h4>Posting fee is absolutely cheap, $0.50 per item only!</h4>
                    <a class="btn btn-primary btn-lg" href="">Post item here</a>
            </div>
            <div class="ww-tab-panel container text-center" id="discuss">
                <h2>Ask questions or help others</h2>
                <h4>want to talk and find out more about watches? Please join our discussion</h4>
                <a class="btn btn-primary btn-lg" href="">Join the forum</a>
            </div>
            <div class="ww-tab-panel container text-center" id="social">
                <h2>Cyberwatch cafe is a great place to know new people, just like a real cafe</h2>
                <h4>make friends and connect with other watch enthusiasts anywhere across the globe</h4>
                <a class="btn btn-primary btn-lg" href="">Get more social</a>
            </div>
                
        </div>
    </div>
    
</div>