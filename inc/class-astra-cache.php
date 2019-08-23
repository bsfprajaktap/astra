<?php
/**
 * Astra Helper.
 *
 * @package Astra
 */

/**
 * Class Astra_Cache.
 */
class Astra_Cache {

	/**
	 * Member Variable
	 *
	 * @var array instance
	 */
	private static $dynamic_css_files = array();

	/**
	 * Member Variable
	 *
	 * @var string instance
	 */
	private static $dynamic_css_data = '';

	/**
	 * Asset slug for filename.
	 *
	 * @since x.x.x
	 * @var string
	 */
	private $asset_slug = '';

	/**
	 * Check if we are on a single or archive query page.
	 *
	 * @since x.x.x
	 * @var string
	 */
	private $asset_query_var = '';

	/**
	 * Asset Type - archive/post
	 *
	 * @since x.x.x
	 * @var string
	 */
	private $asset_type = '';

	/**
	 * Uploads directory.
	 *
	 * @since x.x.x
	 * @var array
	 */
	private $uploads_dir = array();

	/**
	 * Cache directory from uploads folder.
	 *
	 * @since x.x.x
	 * @var String
	 */
	private $cache_dir;

	/**
	 *  Constructor
	 */
	public function __construct( $cache_dir ) {
		$this->cache_dir = $cache_dir;

		add_action( 'wp', array( $this, 'init_cache' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'get_css_from_files' ), 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'setup_cache' ) );

		add_action( 'save_post', array( $this, 'astra_refresh_assets' ) );
		add_action( 'post_updated', array( $this, 'astra_refresh_assets' ) );

		// Refresh assets.
		add_action( 'customize_save_after', array( $this, 'astra_refresh_assets' ) );

		// Triggers on click on refresh/ recheck button.
		add_action( 'wp_ajax_astra_refresh_assets_files', array( $this, 'astra_ajax_refresh_assets' ) );
	}

	/**
	 * Setup class variables.
	 *
	 * @since x.x.x
	 * @return void
	 */
	public function init_cache() {
		$this->asset_type      = $this->asset_type();
		$this->asset_query_var = $this->asset_query_var();
		$this->asset_slug      = $this->asset_slug();
		$this->uploads_dir     = astra_filesystem()->get_uploads_dir( $this->cache_dir );

		// Create uploads directory.
		astra_filesystem()->maybe_create_uploads_dir( $this->uploads_dir['path'] );
	}

	/**
	 * Get Current query type. single|archive.
	 *
	 * @since x.x.x
	 * @return String
	 */
	private function asset_query_var() {
		if ( 'post' === $this->asset_type || 'home' === $this->asset_type || 'frontpage' === $this->asset_type ) {
			$slug = 'single';
		} else {
			$slug = 'archive';
		}

		return $slug;
	}

	/**
	 * Get current asset slug.
	 *
	 * @since x.x.x
	 * @return String
	 */
	private function asset_slug() {
		if ( 'home' === $this->asset_type || 'frontpage' === $this->asset_type ) {
			return $this->asset_type;
		} else {
			return $this->asset_type . $this->cache_key_suffix();
		}
	}

	/**
	 * Append queried object ID to cache if it is not `0`
	 *
	 * @since x.x.x
	 * @return Mixed queried object id if that is not 0; else false.
	 */
	private function cache_key_suffix() {
		return get_queried_object_id() !== 0 ? '-' . get_queried_object_id() : false;
	}

	/**
	 * Get the archive title.
	 *
	 * @since  x.x.x
	 * @return $title Returns the archive title.
	 */
	private function asset_type() {
		$title = 'post';

		if ( is_category() ) {
			$title = 'category';
		} elseif ( is_tag() ) {
			$title = 'tag';
		} elseif ( is_author() ) {
			$title = 'author';
		} elseif ( is_year() ) {
			$title = 'year-' . get_query_var( 'year' );
		} elseif ( is_month() ) {
			$title = 'month-' . get_query_var( 'monthnum' );
		} elseif ( is_day() ) {
			$title = 'day-' . get_query_var( 'day' );
		} elseif ( is_tax( 'post_format' ) ) {
			if ( is_tax( 'post_format', 'post-format-aside' ) ) {
				$title = 'asides';
			} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
				$title = 'galleries';
			} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
				$title = 'images';
			} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
				$title = 'videos';
			} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
				$title = 'quotes';
			} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
				$title = 'links';
			} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
				$title = 'statuses';
			} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
				$title = 'audio';
			} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
				$title = 'chats';
			}
		} elseif ( is_post_type_archive() ) {
			$title = 'archives';
		} elseif ( is_tax() ) {
			$tax   = get_taxonomy( get_queried_object()->taxonomy );
			$title = sanitize_key( $tax->name );
		}

		if ( is_home() ) {
			$title = 'home';
		}

		if ( is_front_page() ) {
			$title = 'frontpage';
		}

		return $title;
	}

	/**
	 * Create an array of all the files that needs to be merged in dynamic CSS file.
	 *
	 * @since x.x.x
	 * @param array $file file path.
	 * @return void
	 */
	public static function add_css_file( $file ) {
		self::$dynamic_css_files = array_merge( self::$dynamic_css_files, $file );
	}

	/**
	 * Append CSS style to the theme dynamic css.
	 *
	 * @since x.x.x
	 * @param array $file file path.
	 * @return void
	 */
	public function get_css_from_files() {
		foreach ( self::$dynamic_css_files as $key => $value ) {
			// Get file contents.
			$get_contents = astra_filesystem()->get_contents( $value );
			if ( $get_contents ) {
				self::$dynamic_css_data .= $get_contents;
			}
		}
	}

	/**
	 * Get CSS from files.
	 *
	 * @since x.x.x
	 * @return String CSS from the CSS files.
	 */
	private function get_cache_files_data() {
		return self::$dynamic_css_data;
	}

	/**
	 * Refresh Assets, called through ajax
	 *
	 * @since x.x.x
	 * @return void
	 */
	public function astra_ajax_refresh_assets() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die();
		}

		check_ajax_referer( 'astra-assets-refresh', 'nonce' );

		$this->init_cache();
		astra_filesystem()->reset_filesystem_access_status();

		$this->delete_cache_files();
	}

	/**
	 * Refresh Assets
	 *
	 * @since x.x.x
	 * @return void
	 */
	public function astra_refresh_assets() {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			wp_die();
		}

		$this->init_cache();
		astra_filesystem()->reset_filesystem_access_status();

		$this->delete_cache_files();
	}

	/**
	 * Deletes cache files
	 *
	 * @since x.x.x
	 * @return void
	 */
	public function delete_cache_files() {
		$cache_files = astra_filesystem()->get_filesystem()->dirlist( $this->uploads_dir['path'], false, true );

		foreach ( $cache_files as $file ) {
			// don't delete index.php file.
			if ( 'index.php' === $file['name'] ) {
				continue;
			}

			astra_filesystem()->delete( trailingslashit( $this->uploads_dir['path'] ) . $file['name'], true, 'f' );
		}
	}

	/**
	 * Fetch theme CSS data to be added in the dynamic CSS file.
	 *
	 * @since x.x.x
	 * @return void
	 */
	public function setup_cache() {
		$theme_css_data  = apply_filters( 'astra_dynamic_theme_css', '' );
		$theme_css_data .= self::$dynamic_css_data;

		// Return if there is no data to add in the css file.
		if ( empty( $theme_css_data ) ) {
			return;
		}

		// Call enqueue styles function.
		$this->enqueue_styles( Astra_Enqueue_Scripts::trim_css( $theme_css_data ), 'theme' );
	}

	/**
	 * Enqueue CSS files.
	 *
	 * @param  string $style_data   Gets the CSS data.
	 * @param  string $type         Gets the type theme/addon.
	 * @since  x.x.x
	 * @return void
	 */
	public function enqueue_styles( $style_data, $type ) {
		if ( $this->inline_assets() ) {
			wp_add_inline_style( 'astra-' . $type . '-css', $style_data );
		} else {
			$assets_info    = $this->get_asset_info( $style_data, $type );
			$post_timestamp = $this->get_post_timestamp( $assets_info );

			// Check if we need to create a new file or override the current file.
			if ( ! empty( $style_data ) && true === $post_timestamp['create_new_file'] ) {
				$this->file_write( $style_data, $post_timestamp['timestamp'], $assets_info );
			}

			wp_enqueue_style( 'astra-' . $type . '-dynamic', $this->uploads_dir['url'] . 'astra-' . $type . '-dynamic-css-' . $this->asset_slug . '.css', array( 'astra-' . $type . '-css' ), $post_timestamp['timestamp'] );
		}
	}

	/**
	 * Enqueue the assets inline.
	 *
	 * @since x.x.x
	 * @return boolean
	 */
	private function inline_assets() {
		return apply_filters( 'astra_load_dynamic_css_inline', ! astra_filesystem()->can_access_filesystem() );
	}

	/**
	 * Returns the current Post Meta/ Option Timestamp.
	 *
	 * @since  x.x.x
	 * @param  string $assets_info  Gets the assets path info.
	 * @return array $timestamp_data.
	 */
	public function get_post_timestamp( $assets_info ) {
		// Check if current page is a post/ archive page. false states that the current page is a post.
		if ( 'single' === $this->asset_query_var ) {
			$post_timestamp = get_post_meta( get_the_ID(), 'astra_style_timestamp_css', true );
		} else {
			$post_timestamp = get_option( 'astra_get_dynamic_css' );
		}

		$timestamp_data = $this->maybe_get_new_timestamp( $post_timestamp, $assets_info );

		return $timestamp_data;
	}

	/**
	 * Gets the current timestamp.
	 *
	 * @since x.x.x
	 * @return string $timestamp Timestamp.
	 */
	private function get_current_timestamp() {
		$date      = new DateTime();
		$timestamp = $date->getTimestamp();

		return $timestamp;
	}

	/**
	 * Returns the current Post Meta/ Option Timestamp or creates a new timestamp.
	 *
	 * @since  x.x.x
	 * @param  string $post_timestamp Timestamp of the post meta/ option.
	 * @param  string $assets_info  Gets the assets path info.
	 * @return array $data.
	 */
	public function maybe_get_new_timestamp( $post_timestamp, $assets_info ) {
		// Creates a new timestamp if the file does not exists or the timestamp is empty.
		// If post_timestamp is empty that means it is an new post or the post is updated and a new file needs to be created.
		// If a file does not exists then we need to create a new file.
		if ( '' == $post_timestamp || ! file_exists( $assets_info['path'] ) ) {
			$timestamp = $this->get_current_timestamp();

			$data = array(
				'create_new_file' => true,
				'timestamp'       => $timestamp,
			);
		} else {
			$timestamp = $post_timestamp;
			$data      = array(
				'create_new_file' => false,
				'timestamp'       => $timestamp,
			);
		}

		return $data;
	}

	/**
	 * Returns an array of paths for the CSS assets
	 * of the current post.
	 *
	 * @param  var    $data         Gets the CSS for the current Page.
	 * @param  string $type         Gets the type theme/addon.
	 * @since x.x.x
	 * @return array
	 */
	public function get_asset_info( $data, $type ) {
		$css_suffix = 'astra-' . $type . '-dynamic-css';
		$css_suffix = 'astra-' . $type . '-dynamic-css';
		$info       = array();
		if ( ! empty( $data ) ) {
			$info['path']    = $this->uploads_dir['path'] . $css_suffix . '-' . $this->asset_slug . '.css';
			$info['css_url'] = $this->uploads_dir['url'] . $css_suffix . '-' . $this->asset_slug . '.css';
		}

		return $info;
	}

	/**
	 * Updates the Post Meta/ Option Timestamp.
	 *
	 * @param  string $timestamp    Gets the current timestamp.
	 * @since  x.x.x
	 * @return void
	 */
	public function update_timestamp( $timestamp ) {
		// Check if current page is a post/ archive page. false states that the current page is a post.
		if ( 'single' === $this->asset_query_var ) {
			update_post_meta( get_the_ID(), 'astra_style_timestamp_css', $timestamp );
		} else {
			update_option( 'astra_get_dynamic_css', $timestamp );
		}
	}

	/**
	 * Creates CSS files.
	 *
	 * @param  string $style_data   Gets the CSS for the current Page.
	 * @param  string $timestamp    Gets the current timestamp.
	 * @param  string $assets_info  Gets the assets path info.
	 * @since  x.x.x
	 * @return void
	 */
	public function file_write( $style_data, $timestamp, $assets_info ) {
		astra_filesystem()->put_contents( $assets_info['path'], $style_data );
		$this->update_timestamp( $timestamp );
	}
}

new Astra_Cache( 'astra' );
