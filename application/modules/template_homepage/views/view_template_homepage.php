<!-- content goes here -->
<div id="homepage">
		
        <div class="fleft">
			<?php
            //load sidebar left
            $session_data = $this->native_session->get('verified');
            if(isset($session_data['loggedin']) && $session_data['loggedin'] === true ){
                $this->load->module('template_sideleft_loggedin');
                $this->template_sideleft_loggedin->view_template_sideleft_loggedin(); 
            } else {
                $this->load->module('template_sideleft');
                $this->template_sideleft->view_template_sideleft(); 
            }
            ?>
        </div>

        <div class="fleft" style="width:760px;">
			<?php
            //item listings
            $this->load->module('template_itemlist');
            $this->template_itemlist->view_template_itemlist(); 
            ?>
		</div>
        
</div>