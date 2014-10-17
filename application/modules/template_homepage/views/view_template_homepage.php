<!-- content goes here -->
<div id="homepage">
		

    <div class="container">
        <div class="ww-tab-container">
            <div class="ww-tab-panel active" id="buy">
                <div class="container text-center">
                    <h2>We love watches so much we can't stop looking at them</h2>
                    <h4>Search for all kinds and types of watch from other cyberwatches users.</h4>
                </div>
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
    <script>
        $(document).ready(function(){
            $('.ww-tabs').on('click','a',function(e){
                $('.container-center').show();
                $('.ww-tab-container > .ww-tab-panel').removeClass('active');
                var x = $(this).attr('href');
                $(x).addClass('active');
            });
            

            

            
        });
        
    </script>
</div>