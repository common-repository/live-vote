<?php

if ( ! class_exists( 'LV_Widget' ) ) {

	/**
	 * Widget controller class
	 *
	 *
	 */
	class LV_Widget extends LV_Module {
    protected $settings;

    public function __construct() {
      $this->register_hook_callbacks();
    }

    /**
  	 * Append Live Vote widget code to the content.
  	 *
  	 * @param string $content
  	 */
  	public function inject_widget() {
      $inject = false;
      $publisher_id = $this->settings['basic']['publisher-id'];
      $question = get_the_title();
      $post_id = get_the_ID();

			// Do not inject widget code on homepage or when there is no featured post thumbnail
			if (!is_singular('post') || is_home() || !has_post_thumbnail($post_id))
				return;

      if (!empty($post_id)) {
        $stored_question = get_post_meta($post_id, 'lv-question', true);
        $inject = get_post_meta($post_id, 'lv-enabled', true);

        if (!empty($stored_question))
          $question = $stored_question;
      }

      if ($inject || (!empty($publisher_id) && $this->settings['basic']['all-posts'])) {
        echo(' <div class="livevote-widget">' . self::render_template( 'widget/widget.php', array( 'publisher_id' => $publisher_id, 'question' => $question ) ) . '</div>');
      }
    }

		/**
		 * Append Live Vote widget code to the content.
		 *
		 * @param string $content
		 */
		public function modify_post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr) {
			$html = preg_replace('/class="(.*?)"/', 'class="${1}' . ' livevote-thumbnail"', $html);
			return $html;
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
			add_filter( 'post_thumbnail_html', array( $this, 'modify_post_thumbnail_html' ), 10, 5 );
      add_action( 'init', array( $this, 'init' ) );
			add_action('wp_footer', array( $this, 'inject_widget' ));
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
