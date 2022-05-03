<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       netkeeper.pl
 * @since      1.0.0
 *
 * @package    Ll_Textbox
 * @subpackage Ll_Textbox/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <div id="icon-themes" class="icon32"></div>  
    <h2>Plugin Name Settings</h2>  
    <?php settings_errors(); ?>  
    <form method="POST" action="options.php">  
        <?php 
            settings_fields( 'll_textbox_general_settings' );
            do_settings_sections( 'll_textbox_general_settings' ); 
        ?>             
        <?php submit_button(); ?>  
    </form> 
</div>