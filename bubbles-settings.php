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
						<label for="menu"><?php _e( 'Style Notifications in Admin Menu', 'bbls' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="menu" value="yes"<?php echo get_option('menu') == 'yes' ? ' checked' : '';?> />
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row" class="indent">
						<label for="bar"><?php _e( 'Style Notifications in Adminbar', 'bbls' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="bar" value="yes"<?php echo get_option('bar') == 'yes' ? ' checked' : '';?> />
					</td>
				</tr>				

			</table>

			<?php submit_button(); ?>
			
		</form>
		
		<footer>
			<p>Thanks for using Bubbles. Created by <a href="http://mkretschmann.com">Matthias Kretschmann</a> (<a href="https://twitter.com/kremalicious">@kremalicious</a>)</p>
		</footer>
		
	</div>