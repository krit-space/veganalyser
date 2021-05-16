<?php
/**
 * Template part for displaying slider content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Bloguten 1.0.0
 */
?>
<?php
	$class = '';
	if( bloguten_get_option( 'slider_content_alignment' ) == 'center' ){
		$class = 'text-center';
	}
?>
<div class="banner-overlay">
	<div class="container">
    	<div class="slide-inner <?php echo esc_attr( $class ); ?>">
			<article class="post">
				<div class="post-content">
					<?php
					if( 'post' == get_post_type() ):
						$bloguten_cat = bloguten_get_the_category();
						if( $bloguten_cat ):
					?>
							<span class="cat">
								<?php
									$term_link = get_category_link( $bloguten_cat[ 0 ]->term_id );
								?>
								<a href="<?php echo esc_url( $term_link ); ?>">
									<?php echo esc_html( $bloguten_cat[0]->name ); ?>
								</a>
							</span>
					<?php
						endif;
					endif;
					?>
					<header class="post-title">
						<h2>
							<a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a>
						</h2>
					</header>
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
					<div class="button-container">
						<a href="<?php the_permalink(); ?>" class="button-outline">
							<?php echo bloguten_get_option( 'slider_button_text' ); ?>
						</a>
					</div>
				</div>
			</article>
    	</div>
	</div>
</div>

