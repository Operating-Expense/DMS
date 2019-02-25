<?php

//dump($data);

$atts  = $data['atts'];

?>

<div id = "dms-pricing-table-<?php echo $atts['id']; ?>" class = "dms-pricing-tables" >
    <div class="row">

        <?php foreach ($data['columns'] as $column) : ?>

        <div class = "dms-col col">

            <div class = "dms-pricing-table">
                <h4 class = "dms-title" style="<?php echo $bcolor; ?>"><?php echo $column['title']; ?></h4>

                <div class = "dms-features">
                    <?php
                        $features_exploded = explode(',', $column['features']);
                        $features_list = implode( '<br>', $features_exploded );
                        echo $features_list;
                    ?>
                </div>

                <div class = "dms-prices">
                    <div class = "dms-currency"><?php echo $column['currency']; ?></div>
                    <div class = "dms-price"><?php echo $column['price']; ?></div>
                    <div class = "dms-period"><?php echo $column['period']; ?></div>
                </div>

                <a href="<?php echo $column['button_url']; ?>" class = "dms-button"><?php echo $column['button_title']; ?></a>
            </div>

        </div>

        <?php endforeach; ?>

        <div class="ff-w-100"></div>

    </div>
</div>

<style>
	<?php if ( !empty( $atts['border_color'] ) ) : ?>
	.dms-pricing-table,
	.dms-pricing-table .dms-title{
		border-color: <?php echo $atts['border_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['border_radius'] ) ) : ?>
	.dms-pricing-table {
		border-radius: <?php echo $atts['border_radius']; ?>px !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['border_width'] ) ) : ?>
	.dms-pricing-table,
	.dms-pricing-table .dms-title{
		border-width: <?php echo $atts['border_width']; ?>px !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['header_bg_color'] ) ) : ?>
	.dms-pricing-table .dms-title{
		background-color: <?php echo $atts['header_bg_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['header_text_color'] ) ) : ?>
	.dms-pricing-table .dms-title{
		color: <?php echo $atts['header_text_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_bg_color'] ) ) : ?>
	.dms-pricing-table .dms-button{
		background-color: <?php echo $atts['button_bg_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_hover_bg_color'] ) ) : ?>
	.dms-pricing-table .dms-button:hover{
		background-color: <?php echo $atts['button_hover_bg_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_text_color'] ) ) : ?>
	.dms-pricing-table .dms-button{
		color: <?php echo $atts['button_text_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_hover_text_color'] ) ) : ?>
	.dms-pricing-table .dms-button:hover{
		color: <?php echo $atts['button_hover_text_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_border_color'] ) ) : ?>
	.dms-pricing-table .dms-button{
		border: 1px solid <?php echo $atts['button_border_color']; ?> !important;
	}
	<?php endif; ?>

	<?php if ( !empty( $atts['button_border_width'] ) ) : ?>
	.dms-pricing-table .dms-button{
		border-width: <?php echo $atts['button_border_width']; ?>px !important;
	}
	<?php endif; ?>
</style>
