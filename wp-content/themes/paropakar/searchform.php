<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package WordPress
 * @subpackage Paropakar_Theme
 * @since 1.0
 * @version 1.0.4
 */

?>

<?php $paropakar_unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="row search-form-row">
		<div  class="col-lg-12">
			<input type="search" id="<?php echo esc_attr( $paropakar_unique_id ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search&hellip;', 'placeholder', 'paropakar' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />

			<button class="btn btn-md"><i class="fa fa-search"></i> <span class="screen-reader-text"><?php echo esc_attr_x( 'Search', 'submit button', 'paropakar' ); ?></span>
			</button>
		</div>
	</div>
</form>
