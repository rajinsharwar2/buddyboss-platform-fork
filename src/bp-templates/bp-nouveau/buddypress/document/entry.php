<?php
/**
 * The template for document entry
 *
 * This template can be overridden by copying it to yourtheme/buddypress/document/entry.php.
 *
 * @since   BuddyBoss 1.4.0
 * @package BuddyBoss\Core
 * @version 1.4.0
 */

$document_id      = bp_get_document_id();
$current_group_id = bp_get_current_group_id();
$loggedin_user_id = bp_loggedin_user_id();
?>
<li class="lg-grid-1-5 md-grid-1-3 sm-grid-1-3" data-id="<?php echo esc_attr( $document_id ); ?>" data-date-created="<?php bp_document_date_created(); ?>">
	<div class="bb-photo-thumb">
		<a class="bb-open-document-theatre bb-photo-cover-wrap" data-id="<?php echo esc_attr( $document_id ); ?>" data-attachment-full="<?php bp_document_attachment_image(); ?>" data-activity-id="<?php bp_document_activity_id(); ?>" href="#">
			<img src="<?php echo esc_url( buddypress()->plugin_url . 'bp-templates/bp-nouveau/images/placeholder.png' ); ?>" data-src="<?php bp_document_attachment_image_thumbnail(); ?>" alt="<?php bp_document_title(); ?>" class="lazy"/>
		</a>
		<?php if ( bp_is_my_profile() || ( bp_is_group() && ( ( bp_is_group_media() && groups_can_user_manage_media( $loggedin_user_id, $current_group_id ) ) || ( bp_is_group_albums() && groups_can_user_manage_albums( $loggedin_user_id, $current_group_id ) ) ) ) ) : ?>
			<div class="bb-media-check-wrap">
				<input id="bb-media-<?php echo esc_attr( $document_id ); ?>" class="bb-custom-check" type="checkbox" value="<?php echo esc_attr( $document_id ); ?>" name="bb-media-select" />
				<label class="bp-tooltip" data-bp-tooltip-pos="up" data-bp-tooltip="<?php esc_attr_e( 'Select', 'buddyboss' ); ?>" for="bb-media-<?php echo esc_attr( $document_id ); ?>"><span class="dashicons dashicons-yes"></span></label>
			</div>
		<?php endif; ?>
	</div>
</li>
