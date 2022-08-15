jQuery(document).ready(function() {

    alert ( 'okay' );

    jQuery('<a href="#" id="insert_gallery" class="button">Return to gallery</a>').insertAfter('.ml-submit');   

    jQuery('#insert_gallery').live('click',function() {

        self.parent.tb_remove(); // This closes the thickbox

    });

});