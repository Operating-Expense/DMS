<?php get_header(); ?>
	
	<section id="content" class="container">
		<div class="row">
			<article class="col-12">
				
				<h1><?php esc_html_e( 'К сожалению, мы не можем найти запрашиваемую страницу.', 'dms' ); ?></h1>
				
				<h4><?php esc_html_e( 'Попробуйте найти что-то еще, используя форму ниже.', 'dms' ); ?></h4>
				
				<?php get_search_form(); ?>
			
			</article>
		
		</div>
	</section>

<?php get_footer();
