<?php
/*
Plugin Name: Author Notifier
plugin URI: https://github.com/zparnold/author-notifier
Description: Send authors an email
version: 1.0
Author: Zach Arnold + 99 Robots
Author URI: https://zacharnold.org
License: GPL2
*/

require_once ('slack.php');
/**
 * Global Definitions
 */

/* Plugin Name */

if (!defined('AUTHOR_NOTIFIER_PLUGIN_NAME'))
    define('AUTHOR_NOTIFIER_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));

/* Plugin directory */

if (!defined('AUTHOR_NOTIFIER_PLUGIN_DIR'))
    define('AUTHOR_NOTIFIER_PLUGIN_DIR', plugin_dir_path(__FILE__) );

/* Plugin url */

if (!defined('AUTHOR_NOTIFIER_PLUGIN_URL'))
    define('AUTHOR_NOTIFIER_PLUGIN_URL', plugins_url() . '/' . AUTHOR_NOTIFIER_PLUGIN_NAME);

/* Plugin verison */

if (!defined('AUTHOR_NOTIFIER_VERSION_NUM'))
    define('AUTHOR_NOTIFIER_VERSION_NUM', '1.0');


/**
 * Activatation / Deactivation
 */

register_activation_hook( __FILE__, array('AuthorNotifier', 'register_activation'));

/**
 * Hooks / Filter
 */

add_action('transition_post_status', array('AuthorNotifier', 'author_notifier_send_email'), 10, 3 );
add_action('init', array('AuthorNotifier', 'load_textdoamin'));




	/**
	 * version_setting_name
	 *
	 * (default value: 'author_notifier_verison')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $version_setting_name = 'author_notifier_version';

	/**
	 * text_domain
	 *
	 * (default value: 'author-notifier')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $text_domain = 'author-notifier';

	/**
	 * settings_page
	 *
	 * (default value: 'author-notifier-admin-settings')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $settings_page = 'author-notifier-admin-settings';

	/**
	 * web_page
	 *
	 * (default value: 'https://github.com/zparnold/author-notifier')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $web_page = 'https://github.com/zparnold/author-notifier';

	/**
	 * facebook_share_link
	 *
	 * (default value: 'https://www.facebook.com/sharer/sharer.php?u=')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $facebook_share_link = 'https://www.facebook.com/sharer/sharer.php?u=';

	/**
	 * twitter_share_link
	 *
	 * (default value: 'https://twitter.com/intent/tweet?url=')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $twitter_share_link = 'https://twitter.com/intent/tweet?url=';

	/**
	 * google_share_link
	 *
	 * (default value: 'https://plus.google.com/share?url=')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $google_share_link = 'https://plus.google.com/share?url=';

	/**
	 * linkedin_share_link
	 *
	 * (default value: 'https://www.linkedin.com/shareArticle?url=')
	 *
	 * @var string
	 * @access private
	 * @
	 */
	 $linkedin_share_link = 'https://www.linkedin.com/shareArticle?url=';

	/**
	 * default
	 *
	 * @var mixed
	 * @access private
	 * @
	 */
	 function default_data() {
		return array(
			'publish_notify'	=> 'author',
			'pending_notify'	=> 'author',
			'post_types'		=> array('post'),
			'message'			=> array(
				'cc_email'						=> '',
				'bcc_email'						=> '',
				'from_email'					=> 'no-reply@' . $_SERVER['HTTP_HOST'],
				'subject_published_contributor'	=> 'Published Article: {post_title}',
				'subject_published'				=> 'Published Article: {post_title}',
				'subject_published_global'		=> 'Published Article: {post_title}',
				'subject_pending'				=> 'Article submitted: {post_title}',
				'content_published_contributor'	=> 'View it: {post_url} {break_line}{break_line}',
				'content_published'				=> '{post_title} was just published! {break_line}{break_line}View it: {post_url}',
				'content_published_global'		=> '{post_title} was just published! {break_line}{break_line}View it: {post_url}',
				'content_pending'				=> '',
				'share_links'					=> array(
					'twitter'	=> true,
					'facebook'	=> true,
					'google'	=> true,
					'linkedin'	=> true
				)
			)
		);
	}

	/**
	 * Load the text domain
	 *
	 * @since 1.0.0
	 */
	 function load_textdoamin() {
		load_plugin_textdomain(self::$text_domain, false, AUTHOR_NOTIFIER_PLUGIN_DIR . '/languages');
	}

	/**
	 * Hooks to 'register_activation_hook'
	 *
	 * @since 1.0.0
	 */
	 function register_activation() {

		/* Check if multisite, if so then save as site option */

		if (is_multisite()) {
			add_site_option(self::$version_setting_name, AUTHOR_NOTIFIER_VERSION_NUM);
		} else {
			add_option(self::$version_setting_name, AUTHOR_NOTIFIER_VERSION_NUM);
		}
	}

	/**
	 * Email all admins when post status changes to pending
	 *
	 * @since 1.0.0
	 */
	 function author_notifier_send_email($new_status, $old_status, $post ) {

		slack("We're inside the send email function");
		/**
		 *
		 */
		//$settings = get_option('author_notifier_settings');
		$settings = false;
		// Default values

		if ($settings === false) {
			$settings = self::default_data();
		}


		$settings['message'] = array(
			'cc_email'						=> $settings['message']['cc_email'] != '' ? $settings['message']['cc_email'] : $default_data['message']['cc_email'],
			'bcc_email'						=> $settings['message']['bcc_email'] != '' ? $settings['message']['bcc_email'] : $default_data['message']['bcc_email'],
			'from_email'					=> $settings['message']['from_email'] != '' ? $settings['message']['from_email'] : $default_data['message']['from_email'],
			'subject_published'				=> $settings['message']['subject_published'] != '' ? $settings['message']['subject_published'] : $default_data['message']['subject_published'],
			'subject_published_contributor'	=> $settings['message']['subject_published_contributor'] != '' ? $settings['message']['subject_published_contributor'] : $default_data['message']['subject_published_contributor'],
			'subject_pending'				=> $settings['message']['subject_pending'] != '' ? $settings['message']['subject_pending'] : $default_data['message']['subject_pending'],
			'content_published'				=> $settings['message']['content_published'] != '' ? $settings['message']['content_published'] : $default_data['message']['content_published'],
			'content_published_contributor'	=> $settings['message']['content_published_contributor'] != '' ? $settings['message']['content_published_contributor'] : $default_data['message']['content_published_contributor'],
			'content_pending'				=> $settings['message']['content_pending'] != '' ? $settings['message']['content_pending'] : $default_data['message']['content_pending'],
			'share_links'	=> array(
				'twitter'	=> $settings['message']['share_links']['twitter'],
				'facebook'	=> $settings['message']['share_links']['facebook'],
				'google'	=> $settings['message']['share_links']['google'],
				'linkedin'	=> $settings['message']['share_links']['linkedin'],
			)
		);


		// If status did not change

		if ($new_status == $old_status) {
			return null;
		}

		// Set all headers

		$headers = array();

		if (isset($settings['message']['from_email']) && $settings['message']['from_email'] != '') {
			$headers[] = "From: " . $settings['message']['from_email'] . "\r\n";
		}

		if (isset($settings['message']['cc_email']) && $settings['message']['cc_email'] != '') {
			$headers[] = "Cc: " . $settings['message']['cc_email'] . "\r\n";
		}

		if (isset($settings['message']['bcc_email']) && $settings['message']['bcc_email'] != '') {
			$headers[] = "Bcc: " . $settings['message']['bcc_email'] . "\r\n";
		}

		if (isset($settings['message']['share_links'])) {
			$check = false;
			foreach ($settings['message']['share_links'] as $link) {
				if ($link) {
					$share_links_check = true;
				}
			}
		}

		$url = get_permalink($post->ID);
		$share_links = '';


		/**
		 * Add sharing links are set
		 */
		if (isset($share_links_check) && $share_links_check) {
			$share_links = "\r\n\r\nShare Links\r\n";

			if ($settings['message']['share_links']['twitter']) {
				$share_links .= "Twitter: " . esc_url(self::$twitter_share_link . $url) . "\r\n";
			}

			if ($settings['message']['share_links']['facebook']) {
				$share_links .= "Facebook: " . esc_url(self::$facebook_share_link . $url) . "\r\n";
			}

			if ($settings['message']['share_links']['google']) {
				$share_links .= "Google+: " . esc_url(self::$google_share_link . $url) . "\r\n";
			}

			if ($settings['message']['share_links']['linkedin']) {
				$share_links .= "LinkedIn: " . esc_url(self::$linkedin_share_link . $url) . "\r\n";
			}
		}

		// Notifiy Author that he/she has written a post

	    if (in_array($post->post_type, $settings['post_types']) && $new_status == 'pending') {

	    	$url = get_permalink($post->ID);
	    	$edit_link = get_edit_post_link($post->ID, '');
			$preview_link = get_permalink($post->ID) . '&preview=true';
	    	$username = get_userdata($post->post_author);
			$author_email = $username -> user_email;

			$subject = self::parse_tags($post, $username, $settings['message']['subject_pending']);
			$message = self::parse_tags($post, $username, $settings['message']['content_pending']);

	    	$message .= "\r\n\r\n";
			$message .= "Dear $username->display_name,"."\r\n";
	    	$message .= "Thank you for submitting your article to Charismedica. This is a confirmation email for your records. ";
			$message .= "Please find below information on your article. \r\n \r\n";
			$message .= "ID: $post->ID \r\n";
	    	$message .= "Title: $post->post_title \r\n";
			$message .= "Abstract: $post->post_content \r\n\r\n";
			$message .= "This is an automatically generated email. Please do not respond to it directly. ";
			$message .= "For questions regarding your submission, visit our contact page to get in touch with us. \r\n\r\n";
			$message .= "Best regards, \r\n";
			$message .= "Charismedica";


			$result = wp_mail($author_email, $subject, $message, $headers);
	    }

	    // Notifiy Author when their work is published

	    if (in_array($post->post_type, $settings['post_types']) && $new_status == 'publish') {

	    	// Notify Author that their post was published

	    	if (isset($settings['publish_notify']) && $settings['publish_notify'] == 'author' && $old_status == 'pending' && user_can($post->post_author, 'edit_posts') && !user_can($post->post_author, 'publish_posts')) {

				$username = get_userdata($post->post_author);
				$subject = self::parse_tags($post, get_userdata($post->post_author), $settings['message']['subject_published_contributor']);

				$message .= "Dear $username->display_name,"."\r\n";
				$message .= "Congratulations! Your article was reviewed by our staff and accepted! ";
				$message .= "Please find below information on your article. \r\n \r\n";
				$message .= "ID: $post->ID \r\n";
				$message .= "Title: $post->post_title \r\n";
				$message .= "Abstract: $post->post_content \r\n\r\n";
				$message = self::parse_tags($post, get_userdata($post->post_author), $settings['message']['content_published_contributor']);
				$message .= "This is an automatically generated email. Please do not respond to it directly. ";
				$message .= "For questions regarding your submission, visit our contact page to get in touch with us. \r\n\r\n";
				$message .= "Best regards, \r\n";
				$message .= "Charismedica";
				$message .= $share_links;

				$result = wp_mail($username->user_email, $subject, $message, $headers);
			}

			// Notify All Admins or All Users

			}
	    }

	/**
	 * Parse the tags added by people
	 *
	 * @access public
	 * @
	 * @return void
	 */
	 function parse_tags($post, $user, $text){

		// Replace post title

		$text = str_replace('{post_title}', $post->post_title, $text);

		// Replace post url

		$text = str_replace('{post_url}', get_permalink($post->ID), $text);

		// Replace post type

		$text = str_replace('{post_type}', $post->post_type, $text);

		// Replace user display name

		$text = str_replace('{display_name}', $user->display_name, $text);

		// Add a break line

		$text = str_replace('{break_line}', "\r\n", $text);

		return $text;

	}

	/**
	 * Returns all post types that are queryable and public
	 *
	 * @access public
	 * @
	 * @return void
	 */
	 function get_post_types() {

		$post_types = get_post_types(array('public' => true));

		unset($post_types['attachment']);
		unset($post_types['page']);

		return $post_types;
	}

?>