<div class="top-footer">
	<div class="container">
		<?php if( !bloguten_get_option( 'disable_footer_widget' ) ):
		
		if( bloguten_is_active_footer_sidebar() ):
		?>
			<div class="footer-widget-wrap">
				<div class="row">
				<?php
					$count = 0;
					for( $i = 1; $i <= 4; $i++ ){
						?>
							<?php if ( is_active_sidebar( 'bloguten-footer-sidebar-'.$i ) ) : ?>
								<div class="col-lg-3 col-md-6 col-12 footer-widget-item">
								<?php dynamic_sidebar( 'bloguten-footer-sidebar-'.$i ); ?>
								</div>
							<?php endif; ?>
						<?php
					}
					if( $count > 0 ){
						$return = true;
					}else{
						$return = false;
					}
				?>
				</div>
			</div>
		<?php
			endif;
		endif
		?>
	</div>
</div>