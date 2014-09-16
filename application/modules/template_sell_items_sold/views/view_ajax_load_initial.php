<!-- content goes here -->
<?php
if($results != NULL || !empty($results)){
 
   foreach($results as $r)
    {
        echo  $r->item_name . '<br />'; // your fields/whatever you want to output.
    }		

} else {
	
	echo "<div class='no_data'>You have 0 items sold yet. Sell new items <a href='".base_url()."dashboard/sell/new'>here.</a></div>";
	
}
?>		
