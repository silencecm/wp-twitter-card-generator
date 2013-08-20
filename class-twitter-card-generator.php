<?php
/**
 * Plugin Name.
 *
 * @package   Twitter_Card_Generator
 * @author    Riley MacDonald <riley_macdonald@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://rileymacdonald.ca
 * @copyright 2013 Riley MacDonald
 */

/**
 * Plugin class.
 *
 * @package Twitter_Card_Generator
 * @author  Riley MacDonald <riley_macdonald@hotmail.com>
 */
class Twitter_Card_Generator {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'twitter-card-generator';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.1
	 */
	private function __construct() {
		//Init
		add_action( 'init', array( $this, 'init_setup') );
	}//end constructor statement

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}//end get_instance

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		//Init the plugin with summary card as the default card type
		//TODO: update_option( 'twitter-card-type', 'summary' );
	}//end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		//Remove the database fields associated with this plugin
		//TODO: delete_option( 'array of options used with this plugin' );
	}//end deactivate

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	}//end load_plugin_textdomain

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		}
	}//end enque_admin_styles

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {
		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $screen->id == $this->plugin_screen_hook_suffix ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'js/admin.js', __FILE__ ), array( 'jquery' ), $this->version );
		}
	}//end enqueue_admin_scripts

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'css/public.css', __FILE__ ), array(), $this->version );
	}//end enqueue_styles

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'js/public.js', __FILE__ ), array( 'jquery' ), $this->version );
	}//end enqueue_scripts

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		//Get the admin page
		include_once( 'views/admin.php' );
		//Javascript
		wp_enqueue_script( 'Twitter Card Generator', plugins_url() . '/' . $this->plugin_slug . '/js/admin.js');
	}//end display_plugin_admin_page

	/**
	* Run through constructor to add actions
	*
	* @since 		1.0.1
	*/
	public function init_setup() {
		//Enque styles for the admin page
		wp_enqueue_style( 'admin-styles', plugins_url( $this->plugin_slug . '/css/admin.css' ) );
		//Add the seo tags to the header
		add_action( 'wp_head', array( $this, 'generate_tags' ) );
		//Add custom user field for twitter username
		add_action( 'show_user_profile', array($this, 'twitter_user_field' ) );
		add_action( 'edit_user_profile', array($this, 'twitter_user_field' ) );
		//Save the custom twitter user information
		add_action( 'personal_options_update', array( $this, 'twitter_save_user_field' ) );
		add_action( 'edit_user_profile_update', array( $this, 'twitter_save_user_field') );
		//Add the settings link
		add_filter('plugin_action_links_' . plugin_basename( plugin_dir_path( __FILE__ ) . $this->plugin_slug . '.php'), array($this, 'plugin_action_links') );
		//Generate the administration menu
		add_action( 'admin_menu', array( $this, 'twitter_card_generator_admin_menu' ) );
		//Image meta box for Twitter cards on Posts
		add_action( 'load-post.php', array( $this, 'custom_meta_box_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'custom_meta_box_setup' ) );
		//Allow featured images on posts
		add_theme_support( 'post-thumbnails' );
	}//end init_setup

	/**
	* Save custom meta boxes functions
	*
	* @since 1.0.1
	*/
	public function custom_meta_box_setup() {
		//Add custom meta boxes here
	}//end custom_meta_box_setup

	/**
	* Add the settings menu
	*
	* @since 1.0.1
	*/
	public function twitter_card_generator_admin_menu() {
		add_plugins_page(
			'Twitter Card Generator Settings',
			'Twitter Card Generator',
			'manage_options',
			$this->plugin_slug,
			array($this, 'display_plugin_admin_page' )
		);
	}//end twitter_card_generator_admin_menu

	/**
	* Adds the settings menu link to the plugin
	*
	* @since 1.0.1
	*/
	public function plugin_action_links( $links ) {
		return array_merge(
	    array(
	      'settings' => '<a href="' . admin_url( 'plugins.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
	    ),
	    $links
	  );
	}//end plugin_action_links

	/**
	 * Generate Twitter Card meta tags based on the plugin settings
	 *
	 * @since    1.0.0
	 */
	public function generate_tags() {
		global $post;
		//Author
		$author_id = $post->post_author;
		//If the post is of a post type generate the meta tags
		if ( $post->post_type == 'post' ) :	?>
			<meta name="twitter:card" content="<?php echo get_option( 'twitter-card-type' ); ?>" />
			<meta name="twitter:site" content="<?php echo esc_attr( get_the_author_meta( 'twitter', $author_id ) ); ?>" />
			<meta name="twitter:creator" content="<?php echo esc_attr( get_the_author_meta( 'twitter', $author_id ) ); ?>" />
			<?php if ( get_option( 'twitter-card-type' ) != 'app' ) : ?>
				<meta name="twitter:title" content="<?php
					if ( get_option( 'twitter-card-type' ) == 'photo' && get_option( 'twitter-photo-title' ) == '0' ) {
						echo '';
					} elseif ( get_option( 'twitter-card-type' ) == 'photo' && get_option( 'twitter-photo-title' ) == '1' ) {
						echo $post->post_title;
					} else {
					echo $post->post_title;
					}//end if
				?>" />
				<?php if ( get_option( 'twitter-card-type' ) != 'photo' ) : ?>
					<meta name="twitter:description" content="<?php echo $post->post_excerpt; ?>"/>
				<?php endif; //end get_option photo if ?>
				<?php if ( get_option( 'twitter-card-type') != 'gallery' ) : ?>
					<?php if ( has_post_thumbnail( $post->ID ) ) : $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), array( 150, 150 ) ); ?>
						<meta name="twitter:image" content="<?php echo $image[0]; ?>" />
					<?php else : ?>
						<meta name="twitter:image" content="<?php echo get_option('twitter-summary-image'); ?>" />
					<?php endif; //end has_post_thumbnail if ?>
				<?php else :
					//Get the images from the post
					$gallery_images = get_posts( array(
						'post_type' => 'attachment',
						'posts_per_page' => 4,
						'post_parent' => $post->ID,
					) );
					if ( $gallery_images ) {
						$i = -1;
						foreach ( $gallery_images as $imgs ) : $i += 1; ?>
							<meta name="twitter:image<?php echo $i; ?>" content="<?php echo $imgs->guid; ?>">
						<?php endforeach;
					} //end $gallery_images if
				endif; //end gallery_type if
			else : ?>
				<meta name="twitter:description" content="<?php echo $post->post_excerpt; ?>" />
				<meta name="twitter:app:id:iphone" content="<?php echo get_option( 'twitter-app-id-iphone' ); ?>" />
				<meta name="twitter:app:id:ipad" content="<?php echo get_option( 'twitter-app-id-ipad' ); ?>" />
				<meta name="twitter:app:id:googleplay" content="<?php echo get_option( 'twitter-app-id-googleplay' ); ?>" />
				<meta name="twitter:app:url:iphone" content="<?php echo get_option( 'twitter-app-url-iphone' ); ?>" />
				<meta name="twitter:app:url:ipad" content="<?php echo get_option( 'twitter-app-url-ipad' ); ?>" />
				<meta name="twitter:app:url:googleplay" content="<?php echo get_option( 'twitter-app-url-googleplay' ); ?>" />
				<meta name="twitter:app:country" content="<?php echo get_option( 'twitter-app-country' ); ?>" />
			<?php endif; //end app card if ?>
		<?php endif; //end $post->post_type if
	}//end generate_tags

	/**
	* Add twitter information to the user profile admin screen
	*
	* @since 		1.0.1
	*/
	public function twitter_user_field( $user ) { ?>
		<h3>Twitter Information</h3>
		<table class="form-table">
			<tbody>
				<tr>
					<th>
						<label for="description">Twitter Username (include @)</label>
					</th>
					<td>
						<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" />
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}//end twitter_user_field

	/** ADMIN SETTINGS FUNCTIONS **/

	/**
	* Save the custom twitter user meta data
	*
	* @since 1.0.1
	*/
	public function twitter_save_user_field( $user_id ) {
		update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
	}//end twitter_save_user_field

	/**
 * Get the media library files
 *
 * @since 1.0.1
 */
function get_media_library_images() {
	$args = array(
		'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_status' => 'inherit',
    'posts_per_page' => -1,
	);
	$query_images = get_posts( $args );
	$images = array();
	foreach ( $query_images as $image ) {
		//Hide pictures larger then 1MB in size
		if ( filesize( get_attached_file( $image->ID ) ) < 1000000 ) {
			$images[] = $image;
		}
	}
	return $images;
}

/**
 * Display updated message at top of screen
 *
 * @since 1.0.1
**/
function update_message() { ?>
	<div id="message" class="updated below-h2">
		<p>Twitter Card Settings updated. Twitter Card Type set as <?php echo get_option('twitter-card-type'); ?></p>
	</div>
<?php
}
}//end class