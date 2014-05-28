<?php

namespace Taxonomy;

class Attachment {

	/**
	 * @var array
	 */
	public $taxonomies = ['category'];


	public function __construct()
	{
		array_map([$this, 'manage_taxonomies_columns'], $this->taxonomies);
	}

	/**
	 * When the plugin is activated this callback function is called.
	 */
	public static function activation_hook_callback()
	{
		self::create_attachment_row();
	}

	/**
	 * Create a the table row to store the attachment_id
	 *
	 * @uses \wpdb WordPress DB Class
	 */
	public static function create_attachment_row()
	{
		global $wpdb;

		return $wpdb->query(
			"CREATE TABLE IF NOT EXISTS {$wpdb->prefix}term_attachments (
				id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
				term_id BIGINT(20) UNSIGNED NOT NULL,
				attachment_id BIGINT(20) UNSIGNED NOT NULL,
				PRIMARY KEY (id),
				UNIQUE KEY term_attachment_index (term_id, attachment_id),
				INDEX term_id_index (term_id),
				INDEX attachment_id_index (attachment_id),
				FOREIGN KEY (term_id) REFERENCES $wpdb->terms (term_id) ON DELETE CASCADE,
				FOREIGN KEY (attachment_id) REFERENCES $wpdb->posts (ID) ON DELETE CASCADE
			);"
		);
	}

	/**
	 * Display different grafic user interfaces to manage the attachments
	 *
	 * @param $taxonomy
	 */
	public function manage_taxonomies_columns($taxonomy)
	{
		add_filter( "manage_{$taxonomy}_custom_column", [$this, 'taxonomy_rows'], 15, 3 );
		add_filter( "manage_edit-{$taxonomy}_columns", [$this, 'taxonomy_columns'] );
		add_action( "{$taxonomy}_edit_form_fields", [$this, 'edit_tag_form'], 10, 2 );
	}

	/**
	 * @param $row
	 * @param $column_name
	 * @param $term_id
	 *
	 * @return string
	 */
	public function taxonomy_rows( $row, $column_name, $term_id )
	{
		global $taxonomy;
		if ( 'taxonomy_image_plugin' === $column_name )
			return $row . $this->preview_image( $term_id, $taxonomy );

		return $row;
	}

	/**
	 * Add taxonomy custom columns.
	 *
	 * @param $columns
	 * @return array
	 */
	public function taxonomy_columns( $columns )
	{
		$new_columns = $columns;
		array_splice( $new_columns, 1 );
		$new_columns['taxonomy_image_plugin'] = 'Image';

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Add custom form field to rhe  edit tag form.
	 *
	 * @param $term
	 * @param $taxonomy
	 */
	public function edit_tag_form( $term, $taxonomy )
	{
		require_once plugin_dir_path( __FILE__ ).'templates/form-field.php';
	}

	/**
	 * Display the image preview.
	 *
	 * @param $term_id
	 * @param $taxonomy
	 * @return string
	 */
	public function preview_image( $term_id, $taxonomy )
	{
		//echo self::thumbnail($term_id);
		echo 'lol';
	}

	/**
	 * @param $term_id
	 *
	 * @return mixed
	 */
	public static function get_attchment_id( $term_id ) {

		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare(
			"SELECT attachment_id FROM {$wpdb->prefix}term_attachments WHERE term_id = %d", $term_id
		) );
	}

	/**
	 * Display the image preview.
	 *
	 * @param $term_id
	 * @param string $size
	 * @param string $attr
	 *
	 * @return string
	 */
	public static function thumbnail( $term_id, $size = 'post-thumbnail', $attr = '' )
	{
		$attachment_id = self::get_attchment_id( $term_id );

		return wp_get_attachment_image( $attachment_id, $size, false, $attr );
	}



}
