jQuery( document ).ready(
	function() {

			var $tagsSelect   = jQuery( 'body' ).find( '.bbp_topic_tags_dropdown' );
			var tagsArrayData = [];

	if ( $tagsSelect.length ) {
		$tagsSelect.select2({
			placeholder: $tagsSelect.attr('placeholder'),
			minimumInputLength: 1,
			closeOnSelect: true,
			tags: true,
			language: ( typeof bp_select2 !== 'undefined' && typeof bp_select2.lang !== 'undefined' ) ? bp_select2.lang : 'en',
			dropdownCssClass: 'bb-select-dropdown',
			containerCssClass: 'bb-select-container',
			tokenSeparators: [',', ' '],
			ajax: {
				url: bbpCommonJsData.ajax_url,
				dataType: 'json',
				delay: 1000,
				data: function (params) {
					return jQuery.extend({}, params, {
						_wpnonce: bbpCommonJsData.nonce,
						action: 'search_tags',
					});
				},
				cache: true,
				processResults: function (data) {

					// Removed the element from results if already selected.
					if (false === jQuery.isEmptyObject(tagsArrayData)) {
						jQuery.each(tagsArrayData, function (index, value) {
							for (var i = 0; i < data.data.results.length; i++) {
								if (data.data.results[i].id === value) {
									data.data.results.splice(i, 1);
								}
							}
						});
					}

					return {
						results: data && data.success ? data.data.results : []
					};
				}
			}
		});

		// Add element into the Arrdata array.
		$tagsSelect.on('select2:select', function (e) {
			var data = e.params.data;
			tagsArrayData.push(data.id);
			var tags = tagsArrayData.join(',');
			jQuery('body #bbp_topic_tags').val(tags);

			jQuery( 'body .select2-search__field' ).trigger( 'click' );
			console.log('1');
			jQuery( 'body .select2-search__field' ).trigger( 'click' );
			console.log('111');
		});

		// Remove element into the Arrdata array.
		$tagsSelect.on('select2:unselect', function (e) {
			var data = e.params.data;
			tagsArrayData = jQuery.grep(tagsArrayData, function (value) {
				return value !== data.id;
			});
			var tags = tagsArrayData.join(',');
			jQuery('body #bbp_topic_tags').val(tags);
			if (tags.length === 0) {
				jQuery(window).scrollTop(jQuery(window).scrollTop() + 1);
			}
		});

	}
	// "remove all tags" button event listener
	jQuery( 'body' ).on('click', '.js-modal-close', function() {
		$tagsSelect.val('');
		$tagsSelect.trigger( 'change' ); // Notify any JS components that the value changed
		jQuery( 'body' ).removeClass( 'popup-modal-reply' );
	});

			var topicReplyButton = jQuery( 'body .bbp-topic-reply-link' );
		if ( topicReplyButton.length ) {
			topicReplyButton.click(
				function () {
						jQuery( 'body' ).addClass( 'popup-modal-reply' );
						$tagsSelect.val( '' );
						$tagsSelect.trigger( 'change' ); // Notify any JS components that the value changed
				}
			);
		}

		if (typeof BP_Nouveau !== 'undefined' && typeof BP_Nouveau.media !== 'undefined' && typeof BP_Nouveau.media.emoji !== 'undefined' ) {
			if (jQuery( '.bbp-the-content' ).length && typeof jQuery.prototype.emojioneArea !== 'undefined' ) {
				jQuery( '.bbp-the-content' ).each(function(i,element) {
					var elem_id = jQuery( element ).attr('id');
					var key = jQuery( element ).data('key');
					jQuery( '#'+elem_id ).emojioneArea(
						{
							standalone: true,
							hideSource: false,
							container: jQuery('#'+elem_id).closest('form').find( '#whats-new-toolbar > .post-emoji' ),
							autocomplete: false,
							pickerPosition: 'bottom',
							hidePickerOnBlur: true,
							useInternalCDN: false,
							events: {
								ready: function () {
									if (typeof window.forums_medium_topic_editor !== 'undefined' && typeof window.forums_medium_topic_editor[key] !== 'undefined') {
										window.forums_medium_topic_editor[key].setContent( jQuery('#'+elem_id).closest('form').find( '#bbp_topic_content' ).val() );
									}
									if (typeof window.forums_medium_reply_editor !== 'undefined' && typeof window.forums_medium_reply_editor[key] !== 'undefined') {
										window.forums_medium_reply_editor[key].setContent( jQuery('#'+elem_id).closest('form').find( '#bbp_reply_content' ).val() );
									}
									if (typeof window.forums_medium_forum_editor !== 'undefined' && typeof window.forums_medium_forum_editor[key] !== 'undefined') {
										window.forums_medium_forum_editor[key].setContent( jQuery('#'+elem_id).closest('form').find( '#bbp_forum_content' ).val() );
									}
								},
								emojibtn_click: function () {
									if (typeof window.forums_medium_topic_editor !== 'undefined' && typeof window.forums_medium_topic_editor[key] !== 'undefined') {
										window.forums_medium_topic_editor[key].checkContentChanged();
									}
									if (typeof window.forums_medium_reply_editor !== 'undefined' && typeof window.forums_medium_reply_editor[key] !== 'undefined') {
										window.forums_medium_reply_editor[key].checkContentChanged();
									}
									if (typeof window.forums_medium_forum_editor !== 'undefined' && typeof window.forums_medium_forum_editor[key] !== 'undefined') {
										window.forums_medium_forum_editor[key].checkContentChanged();
									}
									jQuery('#'+elem_id)[0].emojioneArea.hidePicker();
								},
							}
						}
					);
				});
			}
		}

		//Add Click event to show / hide text formatting Toolbar in smaller screens
		
		jQuery( 'body' ).on('click', '.bbp-topic-form #whats-new-toolbar .show-toolbar, .bbp-topic-form #whats-new-toolbar .medium-editor-toolbar li.close-btn', function(e) {
			e.preventDefault();
			var medium_editor = jQuery(e.currentTarget).closest('.bbp-form').find('.medium-editor-toolbar');
			if( !medium_editor.find('li.close-btn').length ) {
				medium_editor.find('ul').prepend('<li class="close-btn"><button class="medium-editor-action medium-editor-action-close"><b></b></button></li>');
			}
			medium_editor.toggleClass('active');
			medium_editor.addClass( 'medium-editor-toolbar-active' );
		});
	}
);
