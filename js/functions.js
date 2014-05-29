(function($){

	"use strict";

	$(function(){


		var Uploader = {};

		/**
		 * wp.media options
		 *
		 * @type object
		 */
		Uploader.options = {
			title   : 'Taxonomy Image',
			library : { type: 'image' },
			button  : { close: true }
		};

		/**
		 * Create the media frame.
		 */
		Uploader.mediaFrame = function ()
		{
			this.frame = wp.media( this.options );

			return this.frame;
		};


		Uploader.updateDatabase = function (term_id, attachment_id)
		{
			return $.post(ajax_url, {
				term_id: term_id,
				attachment_id: attachment_id,
				action: 'ajax_save_term_attachment'
			}, 'json');
		};

		/**
		 * Save the term attachment relationship
		 *
		 * @param  {[type]} term_id
		 * @param  {[type]} attachment
		 * @return {[type]}
		 */
		Uploader.save = function (term_id, attachment)
		{
			this.updateDatabase(term_id, attachment.id)
			.done(function (response) {
				console.log(response);
			})
		};


		$('.add-term-image').on('click', function (e) {
			e.preventDefault();

			var term_id = $(this).data('term_id');

			var frame = Uploader.mediaFrame().open();

			/**
			 * When an image is selected, run a callback.
			 */
			frame.on('select', function () {
				var attachment = frame.state().get('selection').first();
				Uploader.save( term_id, attachment );
			});

		});


	});

})(jQuery);
