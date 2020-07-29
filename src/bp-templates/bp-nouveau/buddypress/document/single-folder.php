<?php
/**
 * BuddyBoss - Document Single Folder
 *
 * @since BuddyBoss 1.4.0
 * @package BuddyBoss\Core
 */

global $document_folder_template;
if ( function_exists( 'bp_is_group_single' ) && bp_is_group_single() && bp_is_group_folders() ) {
	$folder_id = (int) bp_action_variable( 1 );
} else {
	$folder_id = (int) bp_action_variable( 0 );
}

$folder_privacy     = bp_document_user_can_manage_folder( $folder_id, bp_loggedin_user_id() );
$can_manage_btn     = ( true === (bool) $folder_privacy['can_manage'] ) ? true : false;
$can_add_btn     	= ( true === (bool) $folder_privacy['can_add'] ) ? true : false;

$bradcrumbs = bp_document_folder_bradcrumb( $folder_id );
if ( bp_has_folders( array( 'include' => $folder_id ) ) ) :
	while ( bp_folder() ) :
		bp_the_folder();

		$total_media = $document_folder_template->folder->document['total'];
		?>
		<div id="bp-media-single-folder">
			<div class="album-single-view" <?php echo 0 === $total_media ? esc_attr( 'no-photos' ) : ''; ?>>
				<div class="bp-media-header-wrap">
					<div class="bp-media-header-wrap-inner">
						<div class="bb-single-album-header text-center">
							<h4 class="bb-title" id="bp-single-album-title"><?php bp_folder_title(); ?></h4>
						</div> <!-- .bb-single-album-header -->
						<div class="bb-media-actions">
							<div id="search-documents-form" class="media-search-form" data-bp-search="document">
								<form action="" method="get" class="bp-dir-search-form" id="group-document-search-form" autocomplete="off">
									<button type="submit" id="group-document-search-submit" class="nouveau-search-submit" name="group_document_search_submit">
										<span class="dashicons dashicons-search" aria-hidden="true"></span>
										<span id="button-text" class="bp-screen-reader-text"><?php esc_html_e( 'Search', 'buddyboss' ); ?></span>
									</button>
									<label for="group-document-search" class="bp-screen-reader-text"><?php esc_html_e( 'Search Documents…', 'buddyboss' ); ?></label>
									<input id="group-document-search" name="document_search" type="search" placeholder="<?php esc_html_e( 'Search Documents…', 'buddyboss' ); ?>">
								</form>
							</div>
							<?php
							if ( is_user_logged_in() && ( bp_is_user_document() || bp_is_my_profile() || bp_is_group() || bp_is_document_directory() ) ) :

								$active_extensions = bp_document_get_allowed_extension();
								if ( ! empty( $active_extensions ) && is_user_logged_in() ) {
									if ( bp_is_active( 'groups' ) && bp_is_group() && $can_add_btn ) {
										?>
										<a class="bp-add-document button small outline" id="bp-add-document" href="#" >
											<i class="bb-icon-upload"></i><?php esc_html_e( 'Upload Files', 'buddyboss' ); ?>
										</a>
										<a href="#" id="bb-create-folder-child" class="bb-create-folder-stacked button small outline">
											<i class="bb-icon-plus"></i><?php esc_html_e( 'Create Folder', 'buddyboss' ); ?>
										</a>
										<?php
									} elseif ( ! bp_is_group() && $can_add_btn ) {
										?>
										<a class="bp-add-document button small outline" id="bp-add-document" href="#" >
											<i class="bb-icon-upload"></i><?php esc_html_e( 'Upload Files', 'buddyboss' ); ?>
										</a>
										<a href="#" id="bb-create-folder-child" class="bb-create-folder-stacked button small outline">
											<i class="bb-icon-folder-stacked"></i><?php esc_html_e( 'Create Folder', 'buddyboss' ); ?>
										</a>
										<?php
									}
								}
								if ( bp_is_active( 'groups' ) && bp_is_group() && $can_manage_btn ) {
									?>
									<div class="media-folder_items">
										<div class="media-folder_actions">
											<a href="#" class="media-folder_action__anchor">
												<i class="bb-icon-menu-dots-v"></i>
											</a>
											<div class="media-folder_action__list">
												<ul>
													<li>
														<a id="bp-edit-folder-open" href="#"><i
																class="bb-icon-edit-square-small"></i><?php esc_html_e( 'Edit Folder', 'buddyboss' ); ?>
														</a>
													</li>
													<li><a href="#" id="bb-delete-folder"><i
																class="bb-icon-trash"></i><?php esc_html_e( 'Delete Folder', 'buddyboss' ); ?>
														</a></li>
												</ul>
											</div>
										</div>
									</div> <!-- .media-folder_items -->
									<?php
								} elseif ( ! bp_is_group() && $can_manage_btn ) {
									?>
									<div class="media-folder_items">
										<div class="media-folder_actions">
											<a href="#" class="media-folder_action__anchor">
												<i class="bb-icon-menu-dots-v"></i>
											</a>
											<div class="media-folder_action__list">
												<ul>
													<li>
														<a id="bp-edit-folder-open" href="#"><i
																class="bb-icon-edit-square-small"></i><?php esc_html_e( 'Edit Folder', 'buddyboss' ); ?>
														</a>
													</li>
													<li><a href="#" id="bb-delete-folder"><i
																class="bb-icon-trash"></i><?php esc_html_e( 'Delete Folder', 'buddyboss' ); ?>
														</a></li>
												</ul>
											</div>
										</div>
									</div> <!-- .media-folder_items -->
									<?php
								}
								bp_get_template_part( 'document/document-uploader' );
								bp_get_template_part( 'document/create-child-folder' );
								bp_get_template_part( 'document/edit-child-folder' );
							endif;
							?>
						</div> <!-- .bb-media-actions -->
					</div>
					<?php
					if ( '' !== $bradcrumbs ) {
						echo wp_kses_post( $bradcrumbs );
					}
					?>
				</div> <!-- .bp-media-header-wrap -->
				<div id="media-stream" class="media" data-bp-list="document">
					<div id="bp-ajax-loader"><?php bp_nouveau_user_feedback( 'member-document-loading' ); ?></div>
				</div>
			</div>
		</div>
		<?php
	endwhile;
endif;
