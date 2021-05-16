<?php
/** Posts Widget **/

add_action( 'widgets_init', 'paropakar_post_widget_register' );

/**
 * Function for sanatizing database inputs
 */
function paropakar_post_widget_register() {
	register_widget( 'Paropakar_post_widget_class' );
}

/**
 * Function for sanatizing database inputs
 */
class Paropakar_Post_Widget_Class extends WP_Widget {

	/**
	 * Widget Init.
	 */
	function __construct() {
		parent::__construct(
			// Base ID of your widget.
			'paropakar_post_widget',
			// Widget name will appear in UI.
			esc_html__( 'Paropakar: Posts Widget', 'paropakar' ),
			// Widget description.
			array( 'description' => esc_html__( 'Display Recent Posts Widget', 'paropakar' ) )
		);
	}

	/**
	 * Function for front end widget
	 *
	 * @param array $args .
	 * @param array $instance .
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$title      = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$title      = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$categories = $instance['categories'];
		$number     = $instance['number'];

		$query = array(
			'showposts'           => $number,
			'nopaging'            => 0,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'cat'                 => $categories,
		);

		$loop = new WP_Query( $query );

		echo wp_kses(
			$before_widget,
			array(
				'section' => array(
					'id'    => array(),
					'class' => array(),
				),
			)
		);

		if ( $title ) {
			echo wp_kses(
				$before_title . $title . $after_title,
				array(
					'h2' => array(
						'class' => array(),
					),
				)
			);
		}

		if ( $loop->have_posts() ) :
			?>
			<div class="recent-widget">
			<?php
			while ( $loop->have_posts() ) :
				$loop->the_post();
				?>

					<div class="post-widget row">
					<?php if ( ( function_exists( 'has_post_thumbnail' ) ) && ( has_post_thumbnail() ) ) : ?>
						<div class="post-widget-img col-sm-4">
							<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_post_thumbnail( 'paropakar-grid-list-thumb' ); ?></a>
						</div>
						<?php endif; ?>
						<h4 class="col-sm-8">
							<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h4>
					</div>

				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>

			</div>
				<?php

		endif;

		echo wp_kses(
			$after_widget,
			array(
				'section' => array(
					'id'    => array(),
					'class' => array(),
				),
			)
		);

	}

	/**
	 * Creating widget back-end.
	 *
	 * @param array $instance .
	 */
	function form( $instance ) {

		$defaults = array(
			'title'      => esc_html__( 'Latest Posts', 'paropakar' ),
			'number'     => 3,
			'categories' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'paropakar' ); ?></label>
			<input  type="text" class="widefat" id="<?php echo esc_html( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_html( $instance['title'] ); ?>"  />
		</p>

		<p>
		<label for="<?php echo esc_html( $this->get_field_id( 'categories' ) ); ?>"><?php esc_html_e( 'Filter By Category:', 'paropakar' ); ?></label>
		<select id="<?php echo esc_html( $this->get_field_id( 'categories' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'categories' ) ); ?>" class="widefat categories" style="width:100%;">

			<option value='all' 
			<?php
			if ( 'all' === $instance['categories'] ) {
				echo 'selected="selected"';}
			?>
				><?php esc_html_e( 'All Categories:', 'paropakar' ); ?></option>
			<?php $categories = get_categories( 'hide_empty=0&depth=1&type=post' ); ?>
			<?php foreach ( $categories as $category ) { ?>
			<option value='<?php echo esc_html( $category->term_id ); ?>' 
				<?php
				if ( $category->term_id === $instance['categories'] ) {
					echo 'selected="selected"';}
				?>
				><?php echo esc_html( $category->cat_name ); ?></option>
			<?php } ?>
		</select>
		</p>

		<p>
			<label for="<?php echo esc_html( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'paropakar' ); ?></label>
			<input  type="text" class="widefat" id="<?php echo esc_html( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_html( $this->get_field_name( 'number' ) ); ?>" value="<?php echo esc_html( $instance['number'] ); ?>" size="3" />
		</p>


		<?php
	}

	/**
	 * Update the widget settings.
	 *
	 * @param array $new_instance .
	 * @param array $old_instance .
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title']      = wp_strip_all_tags( $new_instance['title'] );
		$instance['categories'] = $new_instance['categories'];
		$instance['number']     = wp_strip_all_tags( $new_instance['number'] );

		return $instance;
	}
}
?>
