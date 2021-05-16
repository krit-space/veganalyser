<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Bloguten 1.0.0
 */
?>
<?php
	$class = '';
	if( bloguten_get_option( 'archive_post_layout' ) == 'grid' ){
		$class = 'col-lg-6 col-md-6 col-12 grid-post';
	}else {
		$class = 'col-12';
	}
	if( bloguten_get_option( 'archive_post_layout' ) == 'grid' && bloguten_get_option( 'archive_layout' ) == 'none' || bloguten_is_search() ){
		$class = 'col-lg-4 col-md-6 col-12 grid-post';
	}
?>
<div class="<?php echo esc_attr( $class ); ?>">
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
		<?php
			$size = 'bloguten-1200-710';
			$args = array(
				'size' => $size,
				);

			# Disabling dummy thumbnails when its in search page, also support for jetpack's infinite scroll
			if( 'post' != get_post_type() && bloguten_is_search() ){
				$args[ 'dummy' ] = false;
			}
		?>
		<?php 
			if( bloguten_get_option( 'archive_post_layout' ) == 'list' && has_post_thumbnail() ){
		?>
			<div class="row">
				<div class="col-lg-6">
		<?php
			}
		?>
		<?php
			if( has_post_thumbnail() ):
		?>
			<div class="text-center">
				<?php bloguten_post_thumbnail( $args ); ?>
			</div>
		<?php
			endif;
		?>
		<?php 
			if( bloguten_get_option( 'archive_post_layout' ) == 'list' && has_post_thumbnail() ){
		?>
			</div> <!-- end col-lg-6 -->
			<div class="col-lg-6">
		<?php
			}
		?>
		<div class="post-content">
			<?php if('post' == get_post_type() && !bloguten_get_option( 'disable_archive_cat_link' ) ){ ?>
				<?php
				$bloguten_cat = bloguten_get_the_category();
				if( $bloguten_cat ):
					?>
					<div class="cat">
						<?php
						$term_link = get_category_link( $bloguten_cat[ 0 ]->term_id );
						?>
						<a href="<?php echo esc_url( $term_link ); ?>">
							<?php echo esc_html( $bloguten_cat[0]->name ); ?>
						</a>
					</div>
				<?php
				endif;
				?>
			<?php } ?>
			<header class="post-title-warp">
				<h3 class="post-title">
					<a href="<?php the_permalink(); ?>">
						<?php echo get_the_title(); ?>
					</a>
				</h3>
				<?php 
					if('post' == get_post_type() ){ 
				?>
					<div class="meta-tag">
						<?php if( !bloguten_get_option( 'disable_archive_date' ) ): ?>
							<div class="meta-time">
								<a href="<?php echo esc_url( bloguten_get_day_link() ); ?>" >
									<?php echo esc_html(get_the_date('M j, Y')); ?>
								</a>
							</div>
						<?php endif; ?>
						<?php if( !bloguten_get_option( 'disable_archive_author' ) ): ?>
							<div class="meta-author">
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<?php echo get_the_author(); ?>
								</a>
							</div>
						<?php endif; ?>
						<?php if( !bloguten_get_option( 'disable_archive_comment_link' ) ): ?>
							<div class="meta-comment">
								<a href="<?php comments_link(); ?>">
									<?php echo absint( wp_count_comments( get_the_ID() )->approved ); ?>
								</a>
							</div>
						<?php endif; ?>
					</div>
				<?php } ?>
			</header>
			<div class="post-text">
			<?php
				$excerpt_length = bloguten_get_option( 'excerpt_length' );
				bloguten_excerpt( $excerpt_length , true );
			?>
			</div>
		</div>
		<?php 
			if( bloguten_get_option( 'archive_post_layout' ) == 'list' && has_post_thumbnail() ){
				?>
					</div> <!-- end col-lg-6 -->
				</div> <!-- end row -->
				<?php
			}
		?>
	</article>
</div>