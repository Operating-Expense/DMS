<?php

use DMS\Helper\Media;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-stat';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

?>
<section <?php echo implode( $attributes ); ?>>
	
	
	<?php if ( ! empty( $atts['title'] ) ) { ?>
		<div class="row">
			<div class="col-12">
				<h2 class="s-stat-title">
					<?php echo $atts['title'] ?>
				</h2>
			</div>
		</div>
	<?php } ?>
	
	<?php if ( ! empty( $atts['items_arr'] ) ) { ?>
		
		<div class="row justify-content-center">
			
			<?php
			foreach ( $atts['items_arr'] as $item ) {
				
				$item_title = ! empty( $item['item_title'] ) ? esc_html( $item['item_title'] ) : '';
				$item_text  = ! empty( $item['item_text'] ) ? esc_html( $item['item_text'] ) : '';
				$item_class = ! empty( $item['item_el_classes'] )
					? ' ' . esc_attr( $item['item_el_classes'] )
					: '';
				
				?>
				
				
				<div class="col-sm-6 col-md-6 col-lg-3">
					
					<div class="s-stat <?php echo $item_class ?>">
						
						<div class="s-stat__body">
							<div class="s-stat__title">
								<?php echo $item_title ?>
							</div>
							<div class="s-stat__text">
								<?php echo $item_text ?>
							</div>
						</div>
					
					</div>
				
				</div>
			
			<?php } ?>
		
		</div>
	
	<?php } ?>

</section>
