<?php $taxonomy = get_taxonomy( $taxonomy ); ?>

<tr class="form-field hide-if-no-js">
	<th scope="row" valign="top">
		<label for="description">Image</label>
	</th>
	<td>
		<?php echo $this->preview_image( $term->term_id, $taxonomy->name ); ?>
		<div class="clear"></div>
		<span class="description">
			Associate an image from your media library to this <?php echo strtolower($taxonomy->labels->singular_name); ?>
		</span>
	</td>
</tr>