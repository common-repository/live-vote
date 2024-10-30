<div class="wrap" id="livevote-settings">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h1><?php esc_html_e( LV_NAME ); ?> Settings</h1>
	<div id="lv-notice" class="updated settings-error notice is-dismissible"></div>

	<form method="post" action="options.php">
		<?php settings_fields( 'lv_settings' ); ?>
		<?php do_settings_sections( 'lv_settings' ); ?>

		<div class="lv-more-options">
			<a href="https://admin.livevote.com/events/settings" target="_blank">Click here for more options</a>
		</div>

		<p class="submit">
			<input type="submit" name="submit" id="submit" class="button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
		</p>
	</form>
</div> <!-- .wrap -->
