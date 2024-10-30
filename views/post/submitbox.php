<div class="misc-pub-section<?php if ($on_all) echo ' enable-on-all'; ?>" id="livevote">

	<?php wp_nonce_field( 'post_livevote', 'pvc_nonce' ); ?>

	<span id="post-livevote">

		<span class="dashicons dashicons-thumbs-up"></span>
		<?php echo __( 'Live Vote', 'post-livevote' ) . ': <b>' . $status . '</b>'; ?>

	</span>

		<a href="#post-livevote" class="edit-post-livevote hide-if-no-js"><?php _e( 'Edit', 'post-livevote' ); ?></a>

		<div id="post-livevote-input-container" class="hide-if-js">
      <?php
        if ($toggle_visible) {
      ?>
      <p>
        <label>
          <input type="checkbox" id="lv-enable-widget" name="lv-enable-widget" value="1" <?php if ( 1 == $enabled) echo 'checked="checked"'; ?>> Enable Live Vote
        </label>
      </p>

      <?php } ?>

			<p><?php _e( 'Question', 'post-livevote' ); ?>:</p>
			<input type="text" name="lv-question" id="lv-post-question-input" value="<?php echo (string) $question; ?>"/><br />
      <span>Leave empty to use post title as a question</span>
			<p>
				<a href="#post-views" class="lv-ok-button hide-if-no-js button"><?php _e( 'OK', 'post-livevote' ); ?></a>
				<a href="#post-views" class="lv-cancel-button hide-if-no-js"><?php _e( 'Cancel', 'post-livevote' ); ?></a>
			</p>

		</div>

</div>
