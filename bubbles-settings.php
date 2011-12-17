<div class="wrap" id="bubblesoptions">
		
		<header>
			<div class="icon32"></div>
			<h2><?php _e( 'Bubbles Options', 'bbls' ); ?></h2>
		</header>
		
		<form method="post" action="options.php">
			<?php settings_fields( 'bubbles' ); ?>

			<table class="form-table">
				
				<tr valign="top">
					<td colspan="2">
						<h2><?php _e( 'View Options', 'bbls' ); ?></h2>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row" class="indent">
						<?php _e( 'Style Notifications in', 'bbls' ); ?>
					</th>
					<td>
						<fieldset>
							<input type="checkbox" name="menu" id="menu" value="yes"<?php echo get_option('menu') == 'yes' ? ' checked' : '';?> />
							<label for="menu"><?php _e( 'Admin Menu', 'bbls' ); ?></label>
							<br />
							<input type="checkbox" name="bar" id="bar" value="yes"<?php echo get_option('bar') == 'yes' ? ' checked' : '';?> />
							<label for="bar"><?php _e( 'Toolbar', 'bbls' ); ?></label>
						</fieldset>
					</td>
				</tr>	

			</table>

			<?php submit_button(); ?>
			
		</form>
		
		<footer>
			<p>Thanks for using Bubbles. Created by <a href="http://mkretschmann.com">Matthias Kretschmann</a> (<a href="https://twitter.com/kremalicious">@kremalicious</a>)</p>
		</footer>
		
	</div>