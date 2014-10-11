<?php
/**
 * Represents the view for the administration dashboard.
 *
 * @package   Badged
 * @author    Matthias Kretschmann <m@kretschmann.io>
 * @license   GPL-2.0+
 * @link      http://kremalicious.com/badged/
 * @copyright 2014 Matthias Kretschmann
 */
?>

<div class="wrap" id="badgedoptions">
	<header>	
		<?php screen_icon(); ?>
		<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	</header>
    
    <form action="options.php" method="POST">
        <?php 
            settings_fields( 'badged_settings' );
            do_settings_sections( 'badged_settings' );
            
            submit_button(); ?>
    </form>

	<footer>
		<p>
			<?php _e('Thanks for using', 'badged'); ?> <a href="https://kremalicious.com/badged/" title="Badged Blog Post">Badged</a> (<a href="https://github.com/kremalicious/Badged/" title="Badged On Github">github</a>) &middot; <a href="http://krlc.us/givecoffee"><strong><?php _e('Donate', 'badged'); ?></strong></a>
			<span class="alignright"><?php _e('Created by', 'badged'); ?> <a class="kremalicious-link" href="http://mkretschmann.com"><span class="kremalicious"></span> Matthias Kretschmann</a> (<a href="https://twitter.com/kremalicious">@kremalicious</a>)</span>
		</p>
	</footer>
	
</div>