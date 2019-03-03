<?php

use DMS\Helper\Media;
use DMS\Helper\Utils;

$atts = $data['atts'];

$attributes = $classes = array();

$classes[] = 'shortcode-rprice';
if ( ! empty( $atts['el_classes'] ) ) {
	$classes[] = esc_html( $atts['el_classes'] );
}

$attributes[] = ! empty( $atts['el_id'] ) ? 'id="' . $atts['el_id'] . '"' : '';
$attributes[] = ! empty( $classes ) ? 'class="' . implode( ' ', $classes ) . '"' : '';

$title       = $atts['title'];
$accent_text = $atts['accent_text'];
$text        = ! empty( $data['content'] )
	? apply_filters( 'the_content', $data['content'] )
	: '';


?>
<section <?php echo implode( $attributes ); ?>>
	
	
	<div class="row justify-content-center">
		
		<div class="col-lg-6 d-lg-flex align-items-lg-center">
			<?php if ( $title ) { ?>
				<h4 class="s-rprice__title">
					<?php echo $title ?>
				</h4>
			<?php } ?>
		</div>
		
		<div class="col-lg-6">
			
			<?php if ( $accent_text ) { ?>
				<div class="s-rprice__accent dms-accent-text">
					<?php echo $accent_text ?>
				</div>
			<?php } ?>
			
			<?php if ( $text ) { ?>
				<div class="s-rprice__text">
					<?php echo $text ?>
				</div>
			<?php } ?>
		
		</div>
	
	</div>


</section>
