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
			title    : 'Taxonomy Image',
			library  : { type: 'image' },
			button   : { close: true },
            multiple : false
		};

		/**
		 * Create the media frame.
         *
		 */
		Uploader.mediaFrame = function (term_id)
		{
            /**
             * @todo pass diferent data (this seems to be the only way to open the frame reliably)
             * @link http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/#gist4351223
             */
           if ( typeof(this.frame) !== 'undefined')
           {
                this.frame.uploader.uploader.param( 'term_id', term_id );

                return this.frame;
           }

            wp.media.model.settings.term_id = term_id;

			this.frame = wp.media.frames.file_frame = wp.media( this.options );


			return this.frame;
		};


		$(document).on('click', '.add-term-image', function (e) {
			e.preventDefault();

            var $this   = $(this),
                term_id = $(this).data('term_id');

			var frame = Uploader.mediaFrame(term_id).open();

			/**
			 * When an image is selected, run a callback.
             *
             * @todo Refactor this fucking mess.
			 */
			frame.on('select', function () {
				var attachment = frame.state().get('selection').first();
                
                console.log(attachment);
              /*  $.post(ajax_url, {
                    term_id: term_id,
                    attachment_id: attachment.id,
                    action: 'ajax_save_term_attachment'
                }, 'json').done(function(response){
                    if (response.success) {
                        var image = $(response.data);
                        $this.replaceWith( image );
                    }
                });*/
			});

		});


	});

})(jQuery);
