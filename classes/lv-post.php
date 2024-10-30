<?php

if ( ! class_exists( 'LV_Post' ) ) {

	/**
	 * Post controller class
	 *
	 *
	 */
	class LV_Post extends LV_Module {
		protected $settings;

    public function __construct() {
      $this->register_hook_callbacks();
    }

		public function submitbox_views() {
			$question = '';
			$enabled = false;
			$status = 'Inactive';
			$toggle_visible = true;
			$post_id = get_the_ID();

			if (!empty($post_id)) {
				$question = (string) get_post_meta($post_id, 'lv-question', true);
				$enabled = (bool) get_post_meta($post_id, 'lv-enabled', true);
			}

			if (!empty($this->settings['basic']['publisher-id']) && $this->settings['basic']['all-posts']) {
				$enabled = true;
				$toggle_visible = false;
			}

			if ($enabled) {
				$status = 'Active';
			}

			echo self::render_template( 'post/submitbox.php', array( 'status' => $status, 'question' => $question, 'enabled' => $enabled, 'toggle_visible' => $toggle_visible, 'on_all' => $this->settings['basic']['all-posts']) );
		}

		/**
		 * Save Live Vote post data.
		 *
		 * @param int $post_id
		 * @param object $post
		 */
		public function save_post($post_id, $post) {

			// break if doing autosave
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_id;

			// break if current user can't edit this post
			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;


			//  Save question
			if (!add_post_meta($post_id, 'lv-question', $_POST['lv-question'], true)) {
				update_post_meta($post_id, 'lv-question', $_POST['lv-question']);
			}

			// Save enabled flag
			if (!add_post_meta($post_id, 'lv-enabled', ($_POST['lv-enable-widget'] == '1'), true)) {
				update_post_meta($post_id, 'lv-enabled', ($_POST['lv-enable-widget'] == '1'));
			}

		}


    /**
		 * Prepares site to use the plugin during activation
		 *
		 * @mvc Controller
		 *
		 * @param bool $network_wide
		 */
		public function activate( $network_wide ) {
		}

		/**
		 * Rolls back activation procedures when de-activating the plugin
		 *
		 * @mvc Controller
		 */
		public function deactivate() {
		}

    /**
		 * Register callbacks for actions and filters
		 *
		 * @mvc Controller
		 */
		public function register_hook_callbacks() {
			add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
			add_action( 'post_submitbox_misc_actions', array( $this, 'submitbox_views' ) );
			add_action( 'init', array( $this, 'init' ) );
		}

    /**
		 * Initializes variables
		 *
		 * @mvc Controller
		 */
		public function init() {
			$this->settings = self::get_settings();
		}

    /**
		 * Executes the logic of upgrading from specific older versions of the plugin to the current version
		 *
		 * @mvc Model
		 *
		 * @param string $db_version
		 */
		public function upgrade( $db_version = 0 ) {
			/*
			if( version_compare( $db_version, 'x.y.z', '<' ) )
			{
				// Do stuff
			}
			*/
		}

    /**
		 * Checks that the object is in a correct state
		 *
		 * @mvc Model
		 *
		 * @param string $property An individual property to check, or 'all' to check all of them
		 * @return bool
		 */
		protected function is_valid( $property = 'all' ) {
			// Note: __set() calls validate_settings(), so settings are never invalid

			return true;
		}

		/**
		 * Retrieves all of the settings from the database
		 *
		 * @mvc Model
		 *
		 * @return array
		 */
		protected static function get_settings() {
      $settings = get_option( 'lv_settings' , array() );
			return $settings;
		}

	}
}
