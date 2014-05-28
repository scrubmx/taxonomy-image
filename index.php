<?php
/**
 * Taxonomy Images
 *
 * Descripción detallada ...
 *
 * @package taxonomy-images
 * @author  Jorge González <scrub.mx@gmail.com>
 * @link    https://twitter.com/scrubmx
 *
 * @wordpress-plugin
 * Plugin Name: Taxonomy Images
 * Plugin URI:  http://tangentlabs.mx/
 * Description: Attachments for taxonomy terms
 * Version:     1.0
 * Author:      @scrubmx
 * Author URI:  https://twitter.com/scrubmx
 */


// REQUIRE NECESARY CLASSES //////////////////////////////////////////////////////////


	require_once( 'Attachment.php' );


// HOOK IN WHEN A USER ACCESSES THE ADMIN AREA ///////////////////////////////////////


	add_action( 'admin_init', function() {
		$instance = new Taxonomy\Attachment();
	});


// REGISTER A FUNCTION TO BE RUN WHEN THE PLUGIN IS ACTIVATED ////////////////////////


	register_activation_hook( __FILE__, [ 'Taxonomy\Attachment', 'activation_hook_callback' ] );


// EXPOSE GLOBAL FUNCTION ////////////////////////////////////////////////////////////


	if ( ! function_exists( 'get_term_thumbnail' ) ) {

		/**
		 * Retrieve the term thumbnail
		 *
		 * @param  int $term_id
		 * @param  string $size Optional. Image size. Defaults to 'thumbnail'.
		 * @param  string|array  $attr Optional. Query string or array of attributes.
		 * @return string HTML img element or empty string on failure.
		 */
		function get_the_term_thumbnail( $term_id, $size = 'thumbnail', $attr = '') {
			return Taxonomy\Attachment::thumbnail( $term_id, $size, $attr );
		}
	}

	/** @todo implement get_the_term_thumbnail */
	/** @todo implement has_term_thumbnail */
