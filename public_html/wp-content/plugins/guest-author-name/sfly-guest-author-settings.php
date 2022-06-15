<?php
	if ( !class_exists( 'guest_author_settings' ) ) {
	/**
	 * guest_author_admin_menu class.
	 */
		class guest_author_settings
		{
			function __construct()
			{

				add_action( 'admin_menu', array( $this, 'guest_author_name_add_admin_menu' ) );
				add_action( 'admin_init', array( $this, 'guest_author_name_settings_init' ) );
			}

			/**
			 * guest_author_name_add_admin_menu function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_name_add_admin_menu(  ) {

				add_options_page( 'Guest Author Name', 'Guest Author Name', 'manage_options', 'guest_author_name', array( $this,  'guest_author_name_options_page' ) );

			}


			/**
			 * guest_author_name_settings_init function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_name_settings_init(  ) {

				register_setting( 'guest_author_pluginPage', 'guest_author_name_settings' );

				add_settings_section(
					'guest_author_name_pluginPage_section',
					'',
					array( $this, 'guest_author_name_settings_section_callback' ),
					'guest_author_pluginPage' );

				add_settings_field(
					'guest_author_name_quickedit',
					__( 'Enable Quick Edit for Guest Author Name', 'guest-author-name' ),
					array( $this, 'guest_author_name_quickedit_render' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'
				);

				add_settings_field(
					'guest_author_name_admin',
					__( 'Display Guest Author in Author Column in Post list/admin', 'guest-author-name' ),
					array( $this, 'guest_author_name_admin' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'
				);
				add_settings_field(
					'guest_author_allow_html',
					__( 'Allow html in guest author description', 'guest-author-name' ),
					array( $this, 'guest_author_allow_html' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'
				);
				add_settings_field(
					'guest_author_include_guest',
					__( 'Exclude guest author posts in Author Archives (beta)', 'guest-author-name' ),
					array( $this, 'guest_author_include_guest' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'
				);
				add_settings_field(
					'guest_author_disable_for_comments',
					__( 'Disable guest author for comments (beta)', 'guest-author-name' ),
					array( $this, 'guest_author_disable_for_comments' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'

				);
				add_settings_field(
					'guest_author_open_new_window',
					__( 'Open Guest Author link in new window (beta)', 'guest-author-name' ),
					array( $this, 'guest_author_open_new_window' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'

				);

				add_settings_field(
					'guest_author_url_selector_single',
					__( 'CSS selector for the author on single posts', 'guest-author-name' ),
					array( $this, 'guest_author_url_selector_single' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'

				);
	/*			add_settings_field(
					'guest_author_url_selector_excerpt',
					__( 'CSS selector for the author on archive/home page', 'guest-author-name' ),
					array( $this, 'guest_author_url_selector_excerpt' ),
					'guest_author_pluginPage',
					'guest_author_name_pluginPage_section'

				)*/
			}


			/**
			 * guest_author_name_quickedit_render function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_name_quickedit_render(  ) {

				$options = get_option( 'guest_author_name_settings' );
				$quickedit = isset( $options['guest_author_name_quickedit'] ) ? true : false ;
		?>
			<input type='checkbox' name='guest_author_name_settings[guest_author_name_quickedit]' <?php checked( $quickedit, 1 ); ?> value='1'>
			<?php

			}

			 /* guest_author_name_admin function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_name_admin(  ) {

				$options = get_option( 'guest_author_name_settings' );
				$admin = isset( $options['guest_author_name_admin'] ) ? true : false ;
		?>
			<input type='checkbox' name='guest_author_name_settings[guest_author_name_admin]' <?php checked( $admin, 1 ); ?> value='1'>
			<?php

			}

			/* guest_author_allow_html function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_allow_html(  ) {

				$options = get_option( 'guest_author_name_settings' );
				$html = isset( $options['guest_author_allow_html'] ) ? true : false ;
		?>
			<input type='checkbox' name='guest_author_name_settings[guest_author_allow_html]' <?php checked( $html, 1 ); ?> value='1'>
			<?php

			}
			/* guest_author_include_guest function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_include_guest(  ) {

				$options = get_option( 'guest_author_name_settings' );
				$include = isset( $options['guest_author_include_guest'] ) ? true : false ;
		?>
			<input type='checkbox' name='guest_author_name_settings[guest_author_include_guest]' <?php checked( $include, 1 ); ?> value='1'>
			<?php

			}

			/**
			 * guest_author_disable_for_comments function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_disable_for_comments(  ) {

				$options = get_option( 'guest_author_name_settings' );
				$disable = isset( $options['guest_author_disable_for_comments'] ) ? true : false ;
		?>
			<input type='checkbox' name='guest_author_name_settings[guest_author_disable_for_comments]' <?php checked( $disable, 1 ); ?> value='1'>
			<br><label>Check this if the guest author name is displaying in the comments instead of the author name</label>
			<?php

			}

			/**
			 * guest_author_open_new_window function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_open_new_window(  ) {

				$options = get_option( 'guest_author_name_settings' );
				$open = isset( $options['guest_author_open_new_window'] ) ? true : false ;
		?>
			<input type='checkbox' name='guest_author_name_settings[guest_author_open_new_window]' <?php checked( $open, 1 ); ?> value='1'>
			<br><label>The css selector must be entered below</label>
			<?php

			}

			function guest_author_url_selector_single() {
				$options = get_option( 'guest_author_name_settings' );
				$selector = esc_attr(  $options['guest_author_url_selector_single'] ) ;
		?>
			<input type='text' name='guest_author_name_settings[guest_author_url_selector_single]' value="<?php echo $selector; ?>">
			<br><label>In order to open the author url in a new window, the css selector must be entered here</label><br><a href="https://www.plugins.shooflysolutions.com/guest-author-name/knowledge-base/enabling-advanced-author-features/">How do I?</a><?php
			}

			/**
			 * guest_author_name_settings_section_callback function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_name_settings_section_callback(  ) {

				//echo __( 'This section description', 'guest-author-name' );

			}


			/**
			 * guest_author_name_options_page function.
			 *
			 * @access public
			 * @return void
			 */
			function guest_author_name_options_page(  ) {

		?>
			<form action='options.php' method='post'>

				<h2>Simply Guest Author Name</h2>

				<?php
				settings_fields( 'guest_author_pluginPage' );
				do_settings_sections( 'guest_author_pluginPage' );
				submit_button();
		?>

			</form>
				   <div>
						<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
						<h3>Thank you for using our plugin. Donations for extended support are appreciated but never required!</h3>
						<input type="hidden" name="cmd" value="_s-xclick">
						<input type="hidden" name="hosted_button_id" value="FTBD2UDXFJDB6">
						<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
						<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
						</form>
					</div>
					<div style="text-align:center">
						<a target-"_blank" href="https://plugins.shooflysolutions.com/guest-author-name/" style="font-size:16px;">Try premium for 7 days</a>
					<div style="text-align:center">
						<a target='_blank' href="https://wordpress.org/support/plugin/guest-author-name/reviews/" style="font-size:16px;">You can also help by rating this plugin!</a>
					</div>
			<?php

			}

		}
	}
	new guest_author_settings();