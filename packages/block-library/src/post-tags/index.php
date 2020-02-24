<?php
/**
 * Server-side rendering of the `core/post-tags` block.
 *
 * @package WordPress
 */

/**
 * Renders the `core/post-tags` block on the server.
 *
 * @param array $attributes The block attributes.
 *
 * @return string Returns the filtered post tags for the current post wrapped inside "a" tags.
 */
function render_block_core_post_tags( $attributes ) {
	$post = gutenberg_get_post_from_context();
	if ( ! $post ) {
		return '';
	}
	$post_tags = get_the_tags();
	if ( ! empty( $post_tags ) ) {
		$output = array_map(
			function ( $tag ) {
				return '<a href="' .
				get_tag_link( $tag->term_id ) .
				'">' .
				$tag->name .
				'</a>';
			},
			$post_tags
		);
		$output = join(
			$attributes['separator'],
			$output
		);
		return ( isset( $attributes['beforeText'] )
			? ( $attributes['beforeText'] . ' ' )
			: ''
		) .
		$output .
		( isset( $attributes['afterText'] )
			? ( ' ' . $attributes['afterText'] )
			: ''
		);
	}
}

/**
 * Registers the `core/post-tags` block on the server.
 */
function register_block_core_post_tags() {
	register_block_type(
		'core/post-tags',
		array(
			'attributes'      => array(
				'beforeText' => array(
					'type' => 'string',
				),
				'separator'  => array(
					'type'    => 'string',
					'default' => ' | ',
				),
				'afterText'  => array(
					'type' => 'string',
				),
			),
			'render_callback' => 'render_block_core_post_tags',
		)
	);
}
add_action( 'init', 'register_block_core_post_tags' );
