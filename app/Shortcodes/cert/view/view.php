<?php

use DMS\Helper\Media;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-cert';
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
				<h2 class="s-cert-title">
					<?php echo $atts['title'] ?>
				</h2>
			</div>
		</div>
	<?php } ?>
	
	<?php if ( ! empty( $atts['items_arr'] ) ) { ?>
		
		<div class="row">
			
			<?php
			foreach ( $atts['items_arr'] as $item ) {
				
				$item_title     = ! empty( $item['item_title'] ) ? esc_html( $item['item_title'] ) : '';
				$item_text      = ! empty( $item['item_text'] )
					? rawurldecode( base64_decode( $item['item_text'] ) )
					: '';
				$item_image_id  = (int) $item['item_image'];
				$item_image_url = wp_get_attachment_url( $item_image_id );
				$item_url       = ! empty( $item['item_url'] ) ? ' ' . esc_url( $item['item_url'] ) : '#';
				$item_class     = ! empty( $item['item_el_classes'] ) ? ' ' . esc_attr( $item['item_el_classes'] ) : '';
				$item_class     .= ! $item_image_url ? ' s-cert-wo-img' : '';
				
				?>
				
				
				<div class="col-sm-6 col-md-3">
					
					<div class="s-cert <?php echo $item_class ?>">
						<?php
						if ( $item_image_url ) { ?>
							
							<?php if ( $item_url ) { ?>
								<a href="<?php echo $item_url ?>" target="_blank">
							<?php } ?>
							
							<?php
							Media::the_img(
								array( 'data-width' => 255, 'data-height' => 382, 'class' => 's-cert__img' ),
								array( 'attachment_id' => $item_image_id )
							);
							?>
							
							<?php if ( $item_url ) { ?>
								</a>
							<?php } ?>
						
						<?php } ?>
						
						<div class="s-cert__body">
							<div class="s-cert__title">
								<?php echo $item_title ?>
							</div>
							<div class="s-cert__text">
								<?php echo $item_text ?>
							</div>
						</div>
					
					</div>
				
				</div>
			
			<?php } ?>
		
		</div>
	
	<?php } ?>

</section>
