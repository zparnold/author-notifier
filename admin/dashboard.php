<div class="nnr-wrap">

	<?php require_once('header.php'); ?>

	<div class="nnr-container">

		<div class="nnr-content">

			<form method="post" class="form-horizontal">

				<div class="page-header" style="margin-top: 0px;">
					<h1 style="margin-top: 0px;"><?php _e('General Settings', self::$text_domain); ?></h1>
				</div>

				<!-- Include these post types -->

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('Post Types', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<em class="help-block"><?php _e('Post status notification emails will only be sent for activity occurring within the following post types.', self::$text_domain); ?></em>
						<?php foreach ($post_types as $post_type) { ?>
							<input type="checkbox" id="author_notifier_settings_post_types_<?php echo $post_type; ?>" name="author_notifier_settings_post_types_<?php echo $post_type; ?>" <?php echo (isset($settings['post_types']) && in_array($post_type, $settings['post_types']) ? 'checked="checked"' : '');?>/><span><?php printf(__('%s', self::$text_domain), $post_type); ?></span><br />
						<?php } ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('Share Links', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<em class="help-block"><?php _e('Encourage sharing of published posts by inserting automatically generated share links to the bottom of the email notifications that are sent.', self::$text_domain); ?></em>

						<input id="author_notifier_settings_message_share_links_twitter" name="author_notifier_settings_message_share_links_twitter" type="checkbox" value="users" <?php echo isset($settings['message']['share_links']['twitter']) && $settings['message']['share_links']['twitter'] ? 'checked="checked"' : ''; ?>><span><?php _e('Twitter', self::$text_domain); ?></span><br />

						<input id="author_notifier_settings_message_share_links_facebook" name="author_notifier_settings_message_share_links_facebook" type="checkbox" value="users" <?php echo isset($settings['message']['share_links']['facebook']) && $settings['message']['share_links']['facebook'] ? 'checked="checked"' : ''; ?>><span><?php _e('Facebook', self::$text_domain); ?></span><br />

						<input id="author_notifier_settings_message_share_links_google" name="author_notifier_settings_message_share_links_google" type="checkbox" value="users" <?php echo isset($settings['message']['share_links']['google']) && $settings['message']['share_links']['google'] ? 'checked="checked"' : ''; ?>><span><?php _e('Google+', self::$text_domain); ?></span><br />

						<input id="author_notifier_settings_message_share_links_linkedin" name="author_notifier_settings_message_share_links_linkedin" type="checkbox" value="users" <?php echo isset($settings['message']['share_links']['linkedin']) && $settings['message']['share_links']['linkedin'] ? 'checked="checked"' : ''; ?>><span><?php _e('LinkedIn', self::$text_domain); ?></span><br />
					</div>
				</div>

				<div class="page-header">
					<h1><?php _e('Email Headers', self::$text_domain); ?></h1>
				</div>

				<!-- From -->

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('From', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<input id="author_notifier_settings_message_from_email" name="author_notifier_settings_message_from_email" type="text" class="form-control" value="<?php echo ( isset($settings['message']['from_email']) ? esc_attr($settings['message']['from_email']) : 'wordpress@' . get_site_url()); ?>" placeholder="<?php _e('email@example.com or email@example.com,another@example.com', self::$text_domain); ?>">
						<em class="help-block"><?php _e('The From email address for all email notifications.  Please enter in emails separated by commas.', self::$text_domain); ?></em>
					</div>
				</div>

				<!-- Cc -->

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('Cc', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<input id="author_notifier_settings_message_cc_email" name="author_notifier_settings_message_cc_email" type="text" class="form-control" value="<?php echo esc_attr($settings['message']['cc_email']); ?>" placeholder="<?php _e('email@example.com or email@example.com,another@example.com', self::$text_domain); ?>">
						<em class="help-block"><?php _e('The Cc email address for all email notifications.  Please enter in emails separated by commas.', self::$text_domain); ?></em>
					</div>
				</div>

				<!-- Bcc -->

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('Bcc', self::$text_domain); ?></label>
					<div class="col-sm-9">
						<input id="author_notifier_settings_message_bcc_email" name="author_notifier_settings_message_bcc_email" type="text" class="form-control" value="<?php echo esc_attr($settings['message']['bcc_email']); ?>" placeholder="<?php _e('email@example.com or email@example.com,another@example.com', self::$text_domain); ?>">
						<em class="help-block"><?php _e('The Bcc email address for all email notifications.  Please enter in emails separated by commas.', self::$text_domain); ?></em>
					</div>
				</div>

				<div class="page-header">
					<h1><?php _e('Custom Emails, Subjects and Messages', self::$text_domain); ?></h1>
				</div>

				<!-- Dynamic Fields Legend -->

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('Dynamic Fields Legend', self::$text_domain); ?></label>
					<div class="col-sm-9">

						<table class="table table-striped table-responsive">
							<thead>
								<th><?php _e('Placeholder', self::$text_domain); ?></th>
								<th><?php _e('Description', self::$text_domain); ?></th>
							</thead>
							<tbody>
								<tr>
									<td><?php _e('{post_title}', self::$text_domain); ?></td>
									<td><?php _e('The title of the post (i.e. Hello World!)', self::$text_domain); ?></td>
								</tr>
								<tr>
									<td><?php _e('{post_type}', self::$text_domain); ?></td>
									<td><?php _e('The type of the post (i.e. post or page).', self::$text_domain); ?></td>
								</tr>
								<tr>
									<td><?php _e('{post_url}', self::$text_domain); ?></td>
									<td><?php _e('The post\'s permalink (i.e. http://example.com/post-title)', self::$text_domain); ?></td>
								</tr>
								<tr>
									<td><?php _e('{display_name}', self::$text_domain); ?></td>
									<td><?php _e('The post author\'s display name (i.e. Bod Smith)', self::$text_domain); ?></td>
								</tr>
								<tr>
									<td><?php _e('{break_line}', self::$text_domain); ?></td>
									<td><?php _e('A new line in the email, this is great for adding spaces between sentences.', self::$text_domain); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>


				<!-- Email sent to contributor when their post is published -->

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('Author\'s Post Published', self::$text_domain); ?><br /><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#post-published-contributor"><?php _e('Example Email', self::$text_domain); ?></button></label>
					<div class="col-sm-9">
						<p class="form-control-static"><em><?php _e('Sent to the author when their post is published.', self::$text_domain); ?></em></p>
						<label><?php _e('Subject', self::$text_domain); ?></label><br/>
						<input id="author_notifier_settings_message_subject_published_contributor" name="author_notifier_settings_message_subject_published_contributor" type="text" class="form-control" value="<?php echo esc_attr($settings['message']['subject_published_contributor']); ?>"/><br/>

						<label><?php _e('Content', self::$text_domain); ?></label><br/>
						<textarea rows="10" cols="50" class="form-control" id="author_notifier_settings_message_content_published_contributor" name="author_notifier_settings_message_content_published_contributor"><?php echo esc_attr($settings['message']['content_published_contributor']); ?></textarea>
					</div>
				</div>

				<!-- Email sent to admin when contributor submits post for review -->

				<div class="form-group">
					<label class="col-sm-3 control-label"><?php _e('Post Submitted for Review', self::$text_domain); ?><br /><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#submit-for-review"><?php _e('Example Email', self::$text_domain); ?></button></label>
					<div class="col-sm-9">
						<p class="form-control-static"><em><?php _e('Sent to author when he/she submits a post for review.', self::$text_domain); ?></em></p>
						<label><?php _e('Subject', self::$text_domain); ?></label><br/>
						<input id="author_notifier_settings_message_subject_pending" name="author_notifier_settings_message_subject_pending" type="text" class="form-control" value="<?php echo esc_attr($settings['message']['subject_pending']); ?>"/><br/>

						<label><?php _e('Content', self::$text_domain); ?></label><br/>
						<textarea rows="10" cols="50" class="form-control" id="author_notifier_settings_message_content_pending" name="author_notifier_settings_message_content_pending"><?php echo esc_attr($settings['message']['content_pending']); ?></textarea>
					</div>
				</div>

				<?php wp_nonce_field('author_notifier_admin_settings'); ?>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="btn btn-info" value="<?php _e('Save Changes', self::$text_domain); ?>">
				</p>

			</form>

			<div class="modal fade" id="post-published-contributor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document" style="margin-top: 10vh;width: 800px;max-width: 100%;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><?php _e('Example Email', self::$text_domain); ?></h4>
						</div>
						<div class="modal-body">
							<img style="width: 100%;" src="<?php echo WPSITE_POST_STATUS_NOTIFICATION_PLUGIN_URL . '/img/post-published-contributor.png'; ?>"/>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', self::$text_domain); ?></button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="submit-for-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document" style="margin-top: 10vh;width: 800px;max-width: 100%;">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><?php _e('Example Email', self::$text_domain); ?></h4>
						</div>
						<div class="modal-body">
							<img style="width: 100%;" src="<?php echo WPSITE_POST_STATUS_NOTIFICATION_PLUGIN_URL . '/img/please-moderate.png'; ?>"/>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close', self::$text_domain); ?></button>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

	<?php require_once('footer.php'); ?>

</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	$( "#tabs" ).tabs();
});
</script>