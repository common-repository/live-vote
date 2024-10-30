

<?php if ( 'lv_all-posts' == $field['label_for'] ) : ?>

	<input type="hidden" id="<?php esc_attr_e( 'lv_settings[basic][lv_publisher-id]' ); ?>" name="<?php esc_attr_e( 'lv_settings[basic][publisher-id]' ); ?>" class="regular-text" value="<?php esc_attr_e( $settings['basic']['publisher-id'] ); ?>" />
	<input type="checkbox" id="<?php esc_attr_e( 'lv_settings_all-posts' ); ?>" name="<?php esc_attr_e( 'lv_settings[basic][all-posts]' ); ?>" value='1' <?php if ( 1 == $settings['basic']['all-posts'] ) echo 'checked="checked"'; ?> />

<?php endif; ?>
