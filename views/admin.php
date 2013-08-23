<?php
/**
 * Admin settings for the Twitter Card Generator
 *
 * @package   Twitter_Card_Generator
 * @author    Riley MacDonald <riley_macdonald@hotmail.com>
 * @license   GPL-2.0+
 * @link      http://rileymacdonald.ca
 * @copyright 2013 Riley MacDonald
 */

$image_url = '';

//Type of card selected
if ( isset( $_POST['type'] ) ) {
	//Get the Twitter card type
	$type = $_POST['type'];
	//Update the type of card selected
	update_option( 'twitter-card-type', $type );

	//Check for a post to save the plugin settings
	if ( isset( $_POST['listbox'] ) ) {
		//Store the post
		$image_url = $_POST['listbox'];
		//Create/Update the option for the twitter image to be used
		update_option( 'twitter-summary-image', $image_url );
	}

	//Check if it is a photo card
	if ( $_POST['type'] == 'photo' ) {
		if ( isset( $_POST['title'] ) ) {
			update_option( 'twitter-photo-title', '0' );
		} else {
			update_option( 'twitter-photo-title', '1' );
		}
	}

	//Check if it is a app card
	if ( $_POST['type'] == 'app' ) {
		//Set the options from the inputs
		if ( isset( $_POST['app-id-iphone'] ) ) {
			update_option( 'twitter-app-id-iphone', $_POST['app-id-iphone'] );
		}
		if ( isset( $_POST['app-id-ipad'] ) ) {
			update_option( 'twitter-app-id-ipad', $_POST['app-id-ipad'] );
		}
		if ( isset( $_POST['app-id-googleplay'] ) ) {
			update_option( 'twitter-app-id-googleplay', $_POST['app-id-googleplay'] );
		}
		if ( isset( $_POST['app-url-iphone'] ) ) {
			update_option( 'twitter-app-url-iphone', $_POST['app-url-iphone'] );
		}
		if ( isset( $_POST['app-url-ipad'] ) ) {
			update_option( 'twitter-app-url-ipad', $_POST['app-url-ipad'] );
		}
		if ( isset( $_POST['app-url-googleplay'] ) ) {
			update_option( 'twitter-app-url-googleplay', $_POST['app-url-googleplay'] );
		}
		if ( isset( $_POST['app-country'] ) ) {
			update_option( 'twitter-app-country', $_POST['app-country'] );
		}
	}
	Twitter_Card_Generator::update_message();
}

	/**
	 * Loop and display all the images from the media library in a selectable listbox
	 *
	 * @since 1.0.1
	 */
	function display_media_library_images() {
		$imgs = Twitter_Card_Generator::get_media_library_images();
		$first = true;
		?>
			<select class="twitter-image" name="listbox" size="10"><?php
					foreach ( $imgs as $img ) :
				?>
					<option value="<?php echo $img->guid; ?>">
						<?php echo $img->post_title; ?>
					</option>
				<?php endforeach;?>
			</select>
		<?php
	}
?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<h3>Twitter Card Options</h3>
	<h4>Your Twitter card must be validated by Twitter in order to work! <a href="#" onclick="window.open('https://dev.twitter.com/docs/cards/validation/validator'); ">Validate Here</a></h4>
	<div>
		This plugin will generate Twitter cards for your WordPress Posts based on the content of the post, and the settings applied here.<br/>
		Be sure to edit your WordPress <a href="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/users.php'; ?>">User Profile</a> and enter your Twitter account name.
	</div>
	<form method="post">
		<div>
			<h4>Twitter Card Type</h4>
			<ul>
				<?php Twitter_Card_Generator::get_card_type_options(); ?>
			</ul>
			<hr/>
		</div>
		<div class="twitter-settings">
			<div class="summary-settings set">
				<h4>Summary Settings</h4>
				<div>
					The card is designed to give the reader a preview of the content before clicking through to your website.<br/>
					<span class="bold">The image used must be larger than 60x60 px in size</span>. Set the desired image for your post by using the "featured image" panel found in the create/edit post screen.<br/>
					You can set a default image to use below for posts which do not have a featured image set.<br/>
					Images larger then 1MB cannot be used, and will not appear in the list below.
				</div><br/>
				<div>
					<img src="../wp-content/plugins/twitter-card-generator/images/web_summary.png"/>
				</div>
				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label for="title">Title: The Post Title</label>
							</th>
						</tr>
						<tr>
							<th>
								<label for="description">Description: The Post Excerpt</label>
							</th>
						</tr>
						<tr>
							<th>
								<label for="iamge">Image to use if post does not have a featured image set:  <a href="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/upload.php'; ?>">Add New</a></label>
							</th>
							<td style="width:200px;">
								<div style="width:200px;">
									<?php echo display_media_library_images(); ?>
								</div>
							</td>
							<td style="vertical-align:top;">
								Current Thumbnail: &nbsp; <img src="<?php echo get_option('twitter-summary-image'); ?>" class="twitter-image-box" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="summary_large_image-settings set">
				<h4>Large Image Summary Settings</h4>
				<div>
					The card is designed to give the reader a preview of the content before clicking through to your website.<br/>
					The image used must be a <span class="bold">minimum width of 280px, and a minimum height of 150px.</span><br/>
					If the image does not meet the size specifications the card will appear without an image attached.<br/>
					Images larger then 1MB cannot be used, and will not appear in the list below.
				</div><br/>
				<div>
					<img src="../wp-content/plugins/twitter-card-generator/images/web_summary_large.png"/>
				</div>
				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label for="title">Title: The Post Title</label>
							</th>
						</tr>
						<tr>
							<th>
								<label for="description">Description: The Post Excerpt</label>
							</th>
						</tr>
						<tr>
							<th>
								<label for="iamge">Image to use if post does not have a featured image set:  <a href="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/upload.php'; ?>">Add New</a></label>
							</th>
							<td style="width:200px;">
								<div style="width:200px;">
									<?php echo display_media_library_images(); ?>
								</div>
							</td>
							<td style="vertical-align:top;">
								Current Thumbnail: &nbsp; <img src="<?php echo get_option('twitter-summary-image'); ?>" class="twitter-image-box" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="photo-settings set">
				<h4>Photo Card Settings</h4>
				<div>
					The Photo Card puts the image front and center in the Tweet.<br/>
					Twitter will automatically resize images to the following sizes:
					<ul style="list-style-type: square; margin-left: 25px;">
						<li>Web: maximum height of 375px, maximum width of 435px</li>
						<li>Mobile (non-retina displays): maximum height of 375px, maximum width of 280px</li>
						<li>Mobile (retina displays): maximum height of 750px, maximum width of 560px</li>
					</ul>
					The image must be <span class="bold">a minimum size of 280px wide by 150px tall.</span> Images which are more the 1MB in file size cannot be used, and will not appear in the list below.<br/>
					Animated GIF's are not supported.
				</div><br/>
				<div>
					<img src="../wp-content/plugins/twitter-card-generator/images/web_photo.png"/>
				</div>
				<table class="form-table">
					<tbody>
						<tr>
							<th>
								<label for="title">Title: The Post Title</label><br/>
								<input type="checkbox" name="title" value="notitle" <?php if ( get_option( 'twitter-photo-title' ) == '0' ) { echo 'checked'; } ?>/> Use No Title
							</th>
						</tr>
						<tr>
							<th>
								<label for="description">Description: The Post Excerpt</label>
							</th>
						</tr>
						<tr>
							<th>
								<label for="iamge">Image to use if post does not have a featured image set:  <a href="<?php echo get_bloginfo( 'wpurl' ) . '/wp-admin/upload.php'; ?>">Add New</a></label>
							</th>
							<td style="width:200px;">
								<div style="width:200px;">
									<?php echo display_media_library_images(); ?>
								</div>
							</td>
							<td style="vertical-align:top;">
								Current Thumbnail: &nbsp; <img src="<?php echo get_option('twitter-summary-image'); ?>" class="twitter-image-box" />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="gallery-settings set">
				<h4>Gallery Settings</h4>
				<div>
					The Gallery Card allows you to represent collections of photos within a Tweet. Use this if your posts feature several images.<br/>
					This Card type is designed to let the user know that there's more than just a single image at the URL shared, but rather a gallery of related images.<br/>
					Add media to your post using the "Add Media" button. The first four images will be featured in the Twitter Gallery Card.<br/><br/>
					If unwanted images are appearing in your card, check to ensure there are no images attached to your post in WordPress media menu.
				</div><br/>
				<div>
					<img src="../wp-content/plugins/twitter-card-generator/images/web_gallery.png"/>
				</div>
			</div>
			<div class="app-settings set">
				<h4>App Settings</h4>
				<div>
					App Card is a great way to better represent mobile applications on Twitter and to drive installs.<br/>
					Use this card to showcase your application by providing information about the application below.<br/>
					This Card type is currently only available on the iOS and Android mobile clients. It is not yet available on web or mobile web.<br/><br/>
				</div><br/>
				<div>
					<img src="../wp-content/plugins/twitter-card-generator/images/ios_app.png"/>
				</div>
				<div>
					* Required
				</div>
				<div>
					<table class="form-table">
						<tbody>
							<tr>
								<th>The numeric representation of your app ID in the App Store (.i.e. "307234931").</th>
								<td class="app-input">* <input type="text" name="app-id-iphone" id="app-id-iphone" value="<?php echo get_option( 'twitter-app-id-iphone '); ?>" /></td>
							</tr>
							<tr>
								<th>The numeric representation of your app ID in the App Store (.i.e. "307234931").</th>
								<td class="app-input">* <input type="text" name="app-id-ipad" id="app-id-ipad" value="<?php echo get_option( 'twitter-app-id-ipad '); ?>" /></td>
							</tr>
							<tr>
								<th>The numeric representation of your app ID in Google Play (.i.e. "com.android.app").</th>
								<td class="app-input">* <input type="text" name="app-id-googleplay" id="app-id-googleplay" value="<?php echo get_option( 'twitter-app-id-googleplay '); ?>" /></td>
							</tr>
							<tr>
								<th>Your app's custom URL scheme (you must include "://" after your scheme name) (iPhone)</th>
								<td class="app-input"><input type="text" name="app-url-iphone" id="app-url-iphone" value="<?php echo get_option( 'twitter-app-url-iphone '); ?>" /></td>
							</tr>
							<tr>
								<th>Your app's custom URL scheme (iPad)</th>
								<td class="app-input"><input type="text" name="app-url-ipad" id="app-url-ipad" value="<?php echo get_option( 'twitter-app-url-ipad '); ?>" /></td>
							</tr>
							<tr>
								<th>If your application is not available in the US App Store, you must set this value to the two-letter country code for the App Store that contains your application.</th>
								<td class="app-input"><input type="text" name="app-country" id="app-country" value="<?php echo get_option( 'twitter-app-country '); ?>" /></td>
							</tr>
							<tr>
								<th>Your app's custom URL scheme (GooglePlay)</th>
								<td class="app-input"><input type="text" name="app-url-googleplay" id="app-url-googleplay" value="<?php echo get_option( 'twitter-app-url-googleplay '); ?>" /></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="player-settings set">
				<h4>Player Settings</h4>
				<div>
					Currently Not Supported
				</div>
			</div>
			<div class="product-settings set">
				<h4>Product Settings</h4>
				<div>
					Currently Not Supported
				</div>
			</div>
		</div>
		<?php submit_button( 'Save Changes', 'primary', 'submit', 'wrap', array()); ?>
	</form>
</div>