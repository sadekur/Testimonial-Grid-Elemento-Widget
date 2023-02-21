<?php
/**
 * Add submenu under cpt 
 */
function arg_register_ref_page() {
	add_submenu_page(
		'edit.php?post_type=arg',
		__( 'Settings', 'arg' ),
		__( 'Settings', 'arg' ),
		'manage_options',
		'arg-setting-page',
		'arg_callback_func'
	);
}
 add_action('admin_menu', 'arg_register_ref_page');
/**
 * Display callback
 */
function arg_callback_func() {
	?>
	<div class="wrap">
		<div class="card card-second">
			<div class="card-body">
				<div class="clrFix"></div>
				<h3><?php _e( 'About the Author', 'cwpt' ) ?>
			</h3>
			<p>My Development Skill:
				<li>Design or customize any type of wordpress cms for exm: a Blog, E-Commerce, Personal site.</li>
				<li>Develop Wordpress Simple Plugin.</li>
				<li>Can assurance qualities of any type of Wordpress plugins or wordpress Theme.</li>
				<li>I have already written a lot of content for the WordPress blog so I have fully experience about it. </li>
				<a href="https://www.linkedin.com/in/sadekur-rahman-b06208165/">If You Hire</a>.<br />
				<strong>Twetter:</strong> <a href="https://twitter.com/rahman_shadekur">Sadekur Rahman</a><br />
				<strong>Skype:</strong> sadekur.rahman1<br />
				<strong>Email:</strong> shadekur.rahman60@gmail.com<br/>

				<strong>Hire Me on:</strong> <a href="https://www.linkedin.com/in/sadekur-rahman-b06208165/" target="_blank">Linkedin</a><br />
				<div class="clrFix"></div>
			</div>
		</div>	
		<h1>
			<?php echo esc_attr(__('Testimonial Settings')); ?>
		</h1>
		<div class="card">
			<div class="card-body">
				<form action="" id="pt_form" class="" method="POST">
					<div class="main-form mt-3 border-bottom">
						<input type="hidden" name="action" value="action-value">
						<?php 
						$get_title_color = get_option( 'title-color-option', false );
						$get_hover_color = get_option( 'hover-color-option', false );
						$get_body_color  = get_option( 'body-color-option', false );
						?>
						<div class="form-group">
							<label for=""><?php echo esc_attr(__('Body Color:')); ?></label>
							<input type="text" name="title_color" value="<?php echo esc_attr($get_title_color); ?>" class="color-picker" placeholder="Enter Color">
							<label for=""><?php echo esc_attr(__('Title Color:')); ?></label>
							<input type="text" name="hover_color" value="<?php echo esc_attr($get_hover_color); ?>" class="color-picker" placeholder="Enter Color">
							<label for=""><?php echo esc_attr(__('Designation Color:')); ?></label>
							<input type="text" name="body_color" value="<?php echo esc_attr($get_body_color); ?>" class="color-picker" placeholder="Enter Color">
						</div>
						<div class="paste-new-forms"></div>
						<div class="successMessage" style="display:none;"><font color="green"><b>Your colors change successfully.:)</b></font></div>
						<?php
						submit_button();
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php
}
function arg_ajax_val() {
	$sanitize_title = sanitize_text_field( $_POST['title_color']);
	$desig_color 	= sanitize_text_field( $_POST['hover_color']);
	$sanitize_body 	= sanitize_text_field( $_POST['body_color']);

	update_option( 'title-color-option', $sanitize_title );
	update_option( 'hover-color-option', $desig_color );
	update_option( 'body-color-option', $sanitize_body );
	wp_send_json( "Data Saved" );
}
add_action( 'wp_ajax_action-value', 'arg_ajax_val' );

//Get all options value
/*get_option( 'title-color-option', true );
get_option( 'hover-color-option', true );
get_option( 'body-color-option', true );*/


