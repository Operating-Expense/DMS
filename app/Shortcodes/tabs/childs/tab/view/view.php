<div class = "dms_tabs_tab">
	<div class = "dms-inside">
		<h4 class = "dms-title">
			<?php if ( $data['atts']['icon'] <> '' ): ?>
                <i class="<?php echo esc_attr( $data['atts']['icon'] ); ?>"></i>
			<?php endif; ?>
            <?php echo wp_kses_post($data['atts']['title']) ?>
        </h4>
		<div class = "dms-tab-content">
			<?php echo wp_kses_post($data["content"]) ?>
		</div>
	</div>
</div>
