<?php
/**
 * BuddyBoss - Media Uploader
 *
 * @since BuddyBoss 1.0.0
 */
?>
<div id="bp-media-uploader" class="bp-media-document-uploader has-folderlocationUI" style="display: none;">
    <transition name="modal">
        <div class="modal-mask bb-white bbm-model-wrap bbm-uploader-model-wrap">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <header class="bb-model-header bg-white">
                        <a href="#" class="bp-media-upload-tab selected" data-content="bp-dropzone-content" id="bp-media-uploader-modal-title"><?php _e( 'Upload', 'buddyboss' ); ?></a>

                        <?php if ( bp_is_single_folder() ) : ?>
                            <a href="#" class="bp-media-upload-tab" data-content="bp-existing-media-content" id="bp-media-select-from-existing"><?php _e( 'Select Documents', 'buddyboss' ); ?></a>
                        <?php endif; ?>

                        <span id="bp-media-uploader-modal-status-text" style="display: none;"></span>

                        <a class="bb-model-close-button" id="bp-media-uploader-close" href="#">
							<span class="dashicons dashicons-no-alt"></span>
						</a>
                    </header>

                    <div class="bb-field-wrap">
                        <div class="bb-dropzone-wrap bp-media-upload-tab-content" id="bp-dropzone-content">
                            <?php if ( bp_is_active('forums') && ! bbp_is_single_forum() && ! bbp_is_single_topic() && ! bp_is_messages_component() ) : ?>
                            <div class="media-uploader-post-content">
                                <textarea name="bp-media-post-content" id="bp-media-post-content" placeholder="<?php bp_is_group() ? _e( 'Write something about your documents, to be shown on the group feed', 'buddyboss' ) : _e( 'Write something about your documents, to be shown on your timeline', 'buddyboss' ); ?>"></textarea>
                            </div>
                            <?php endif; ?>
                            <div class="media-uploader-wrapper">
                                <div class="dropzone" id="media-uploader"></div>
                            </div>
                        </div>
                    </div>

                    <?php
                        $ul = bp_document_user_document_folder_tree_view_li_html( bp_loggedin_user_id() );
                        if ( '' !== $ul ) {
                            ?>
                            <div class="bb-field-wrap">
                            <div class="bb-dropdown-wrap">
                                <label for="bb-folder-location" class="bb-label"><?php _e( 'Destination Folder', 'buddyboss' ); ?></label>
                                <div class="location-folder-list-wrap-main">
                                    <input type="text" class="bb-folder-destination" value="<?php _e( 'Select Folder', 'buddyboss' ); ?>" readonly/>
                                    <div class="location-folder-list-wrap">
                                        <span class="location-folder-back"><i class="dashicons dashicons-arrow-left-alt2"></i></span>
                                        <span class="location-folder-title"><?php   _e( 'Documents', 'buddyboss' ); ?></span>
                                        <?php echo $ul; ?>
                                    </div> <!-- .location-folder-list-wrap -->
                                    <input type="hidden" class="bb-folder-selected-id" value="" readonly/>
                                </div>
                            </div>
                            </div><?php
                        }
                    ?>

	                <?php if ( bp_is_single_folder() ) : ?>
                        <div class="bp-existing-media-wrap bp-media-upload-tab-content" id="bp-existing-media-content" style="display: none;">

                            <?php if ( bp_has_document( array( 'album_id' => 'existing-media' ) ) ) : ?>

                                <ul class="media-list item-list bp-list bb-photo-list grid existing-media-list">

                                    <?php while ( bp_document() ) :
                                        bp_the_document();

                                        bp_get_template_part( 'document/entry' ); ?>

                                    <?php endwhile; ?>

                                    <?php if ( bp_document_has_more_items() ) : ?>

                                        <li class="load-more">
                                            <a class="button outline" href="<?php bp_document_has_more_items(); ?>"><?php _e( 'Load More', 'buddyboss' ); ?></a>
                                        </li>

                                    <?php endif; ?>

                                </ul>

                            <?php else : ?>

                                <?php bp_nouveau_user_feedback( 'media-loop-document-none' ); ?>

                            <?php endif; ?>

                        </div>
	                <?php endif; ?>

                    <footer class="flex align-items-center bb-model-footer">
                        <a class="button outline" id="bp-media-document-add-more" style="display: none;" href="#">+ <?php _e( 'Add more documents', 'buddyboss' ); ?></a>
                        <a class="button push-right" id="bp-media-document-submit" style="display: none;" href="#"><?php _e( 'Done', 'buddyboss' ); ?></a>
                    </footer>

                </div>
            </div>
        </div>
    </transition>
</div>
