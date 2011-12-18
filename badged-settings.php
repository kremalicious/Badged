<div class="wrap" id="badgedoptions">
		
		<header>
			<div class="icon32"></div>
			<h2><?php _e( 'Badged Settings', 'bdgd' ); ?></h2>
		</header>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'badged' ); ?>

			<table class="form-table">
				
				<tr valign="top">
					<td colspan="2">
						<h2><?php _e( 'View', 'bdgd' ); ?></h2>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row" class="indent">
						<?php _e( 'Style Notifications in', 'bdgd' ); ?>
					</th>
					<td>
						<fieldset>
							<input type="checkbox" name="menu" id="menu" value="yes"<?php echo get_option('menu') == 'yes' ? ' checked' : '';?> />
							<label for="menu"><?php _e( 'Admin Menu', 'bdgd' ); ?></label>
							<br />
							<input type="checkbox" name="bar" id="bar" value="yes"<?php echo get_option('bar') == 'yes' ? ' checked' : '';?> />
							<label for="bar"><?php _e( 'Toolbar', 'bdgd' ); ?></label>
						</fieldset>
					</td>
				</tr>	

			</table>

			<?php submit_button(); ?>
			
		</form>
		
		<footer>
			<p><?php _e('Thanks for using', 'bdgd'); ?> <a href="http://www.kremalicious.com/2011/12/badged/" title="Badged Blog Post">Badged</a> (<a href="https://github.com/kremalicious/Badged/" title="Badged On Github">github</a>) &middot; <?php _e('Created by', 'bdgd'); ?> <a href="http://mkretschmann.com">Matthias Kretschmann</a> (<a href="https://twitter.com/kremalicious">@kremalicious</a>)</p>
		</footer>
		
	</div>