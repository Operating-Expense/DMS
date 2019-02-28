<footer id="composer-footer">
	<?php echo DMS()->View->load_composer_layout( 'footer' ); ?>
</footer>

<footer id="footer" class="page-footer">
	
	<div class="container">
		<div class="row">
			
			<div class="col-lg-3 col-md-6">
				<nav class="footer-nav-1">
					<?php
					
					wp_nav_menu(
						array(
							'theme_location' => 'bottom_bar_menu1',
							'container'      => false,
						)
					);
					
					?>
				</nav>
			</div>
			
			<div class="col-lg-3 col-md-6">
				<nav class="footer-nav-2">
					<?php
					
					wp_nav_menu(
						array(
							'theme_location' => 'bottom_bar_menu2',
							'container'      => false,
						)
					);
					
					?>
				</nav>
			</div>
			
			<div class="col-lg-3 col-md-6">
				<div class="footer_box1">
					<?php echo \DMS\Helper\Utils::get_option( 'footer_box1', '' ) ?>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6">
				<div class="footer_box2">
					<?php echo \DMS\Helper\Utils::get_option( 'footer_box2', '' ) ?>
				</div>
			</div>
		
		</div>
	
	</div>
	
	<div class="container-fluid">
		<div id="bottom-bar" class="bottom-bar">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-6 order-2 order-md-1 copyright">
							<?php echo \DMS\Helper\Utils::get_option( 'bottom_bar_text' ); ?>
						</div>
						<div class="col-md-6 order-1 order-md-2 dev-logo">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/opex.svg' ?>" width="103" height="39">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</footer>

</div>

<?php wp_footer(); ?>
</body>
</html>
