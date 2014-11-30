<!-- content goes here -->
<img src='<?php echo base_url(); ?>assets/images/refine_loader.gif' style='display:none'>
<div id="homepage" class="clearfix">
    <diV class="row">
        <div class="col-sm-3 col-md-2 sidebar desktop-sidebar">
            <?php
            //load sidebar left
                $this->load->module('template_sideleft');
                $this->template_sideleft->view_template_filtered_sideleft(); 
            ?>
        </div>
        <div class="col-sm-9 col-md-10 main site-wrapper">
            <button class="btn btn-default filter-btn visible-xs"><i class="fa fa-bars"></i> filter items</button>
            <div class="dim"></div>
                <?php
                $this->load->view('load_filtered_itemlist'); 
                ?>   
        </div>
    </div>
</div>