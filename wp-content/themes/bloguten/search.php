<?php
/**
 * The search template file
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @since Bloguten 1.0.0
 */
get_header();
if( have_posts() ):
	/**
	* Prints Title and  breadcrumbs for archive pages
	* @since Bloguten 1.0.0
	*/
	bloguten_inner_banner();
?>
<section id="main-content">
	<div class="container">
		<div class="row">
			<div class="col-12" id="main-wrap">
				<div class="row masonry-wrapper">
					<?php 
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/archive/content', '' );
						endwhile;
					?>
				</div>
				<div class="col-12">
					<?php
						if( !bloguten_get_option( 'disable_pagination' ) ):
							the_posts_pagination( array(
								'next_text' => '<span>'.esc_html__( 'Next', 'bloguten' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Next page', 'bloguten' ) . '</span>',
								'prev_text' => '<span>'.esc_html__( 'Prev', 'bloguten' ) .'</span><span class="screen-reader-text">' . esc_html__( 'Previous page', 'bloguten' ) . '</span>',
								'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'bloguten' ) . ' </span>',
							) );
						endif;
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
else: 
	get_template_part( 'template-parts/page/content', 'none' );
endif;
get_footer();