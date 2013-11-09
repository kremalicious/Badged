<?php
/**
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The User Interface to the end user.
 *
 * @package   Badged
 * @author    Matthias Kretschmann <m@kretschmann.io>
 * @license   GPL-2.0+
 * @link      http://kremalicious.com/badged/
 * @copyright 2013 Matthias Kretschmann
 */
?>

<div class="wrap" id="badgedoptions">
	<header>	
		<?php screen_icon(); ?>
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	</header>
    
    <?php settings_errors(); ?>
    
    <form action="options.php" method="POST">
        <?php 
            settings_fields( 'badged_settings' ); 
            do_settings_sections( 'badged_settings' ); 
            
            submit_button(); ?>
    </form>

	<footer>
		<p>
			<?php _e('Thanks for using', 'bdgd'); ?> <a href="http://www.kremalicious.com/2011/12/badged/" title="Badged Blog Post">Badged</a> (<a href="https://github.com/kremalicious/Badged/" title="Badged On Github">github</a>) &middot; <a href="http://krlc.us/givecoffee"><strong><?php _e('Donate', 'bdgd'); ?></strong></a>
			<span class="alignright"><?php _e('Created by', 'bdgd'); ?> <a class="kremalicious" href="http://mkretschmann.com">Matthias Kretschmann</a> (<a href="https://twitter.com/kremalicious">@kremalicious</a>)</span>
		</p>
	</footer>
	
</div>