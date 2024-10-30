(function ($) {

	var notice =  function (text) {
		$('#lv-notice').html('<p>' + text + '</p>').show();
	};

	var getAndSetDefaultQuestion = function () {
		$.ajax({
			type: 'GET',
			url: 'https://admin.livevote.com/json/events/configuration',
			dataType : 'json',
			xhrFields: {
				withCredentials: true
			},
			crossDomain: true,
			cache: false,
			success: function (data, status) {
				var question = '';
				if (typeof data.event_configuration === 'undefined') {
					console.log('Error retrieving default question');
					return;
				}

				// Update question field
				question = data.event_configuration.question;

				$('#lv-post-question-input').val(question);
			},
			error: function(xhr, status, error) {
				console.log('Failed to connect to your Live Vote account.');
			}
		});


		return '';
	};

	var savePublisherID = function (publisherID) {

		$.ajax({
			type: 'POST',
			url: '/wp-admin/options.php',
			data: {
				'option_page': 'lv_settings',
				'action': 'update',
				'_wpnonce': $('#_wpnonce').val(),
				'lv_settings[basic][publisher-id]': publisherID,
				'lv_settings[basic][all-posts]': $('#lv_settings_all-posts').is(':checked') ? '1' : '',
			},
			cache: false,
			success: function () {
				notice('We successfully connected to your Live Vote account');
			},
			error: function(xhr, status, error) {
				notice('Failed to update Live Vote settings, please try again later.');
			}
		});
	};

	// Live Vote settings page
	var settingsPage = function ($settings) {

		$('#livevote-auth').on('click', function (e) {
			e.preventDefault();

			$.ajax({
				type: 'GET',
				url: 'https://admin.livevote.com/json/events/configuration',
				dataType : 'json',
				xhrFields: {
					withCredentials: true
				},
				crossDomain: true,
				cache: false,
				success: function (data, status) {
					if (typeof data.eventowner_encoded_id === 'undefined') {
						console.log('Response data contains no Publisher ID');
						return;
					}

					savePublisherID(data.eventowner_encoded_id);
				},
				error: function(xhr, status, error) {
					notice('Failed to connect to your Live Vote account. Please log in to your <a href="https://admin.livevote.com" target="_blank">Live Vote</a> account and repeat the authentication process again.');
				}
			});
		});
	};

	// Post Settings
	var postPage = function ($lv) {

		var enableOnAll = $lv.hasClass('enable-on-all'),
			$status = $('#post-livevote > b'),
			$container = $('#post-livevote-input-container'),
			$edit = $lv.find('.edit-post-livevote'),
			$questionInput = $('#lv-post-question-input');

		if (enableOnAll) {
			console.log('enable on all');
			getAndSetDefaultQuestion();
		}

		// Edit button
		$edit.click( function (e) {
			e.preventDefault();

			if ( $container.is( ":hidden" ) ) {
				$container.slideDown( 'fast' );
				$(this).hide();
			}
		} );

		// Enable toggle/checkbox
		$('#lv-enable-widget').on('change', function () {
			if ($(this).is(':checked')) {
				$status.text('Active');
				return;
			}
			$status.text('Inactive');
		});

		// OK button
		$lv.find('.lv-ok-button' ).on('click', function (e) {
			e.preventDefault();

			$container.slideUp( 'fast' );
			$edit.show();
		});

		// Cancel button
		$lv.find('.lv-cancel-button').on('click', function (e) {
			e.preventDefault();

			$container.slideUp( 'fast' );
			$edit.show();
		});
	};

	$(function () {

		// post views input
    var $lv = $('#livevote'),
			$settings = $('#livevote-settings');

    if ($lv.length) {
      postPage($lv);
    }

		if ($settings.length) {
			settingsPage($settings);
		}

	} );

} )( jQuery );
