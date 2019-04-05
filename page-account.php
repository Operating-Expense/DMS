<?php
/**
 * Template name: Account
 */

if ( ! is_user_logged_in() ) {
	wp_redirect( home_url() );
	exit;
}

get_header();

the_post();


?>
	
	<div class="container">
		<div class="row">
			
			<div class="col-12">
				<?php the_content(); ?>
			</div>
		
		</div>
	</div>

<?php get_footer();