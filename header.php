<?php
$current_user = wp_get_current_user();
$user_id      = $current_user->ID;
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="main-wrapper">
	
	<header id="top">
		
		<div class="container-fluid">
			
			<nav class="navbar">
				
				<div class="navbar-collapse">
					
					<?php
					$img      = \DMS\Helper\Utils::get_option( 'logo_img', 0 );
					$img_html = ! empty( $img['url'] ) ? '<img src="' . esc_url( $img['url'] ) . '" alt="DM Solutions">' : '';
					
					if ( is_front_page() || is_home() ) :
						?>
						<!-- Your site title as branding in the menu -->
						<h1 class="navbar-brand mb-0">
							<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"
							   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
								<?php echo $img_html; ?>
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
					
					<?php else : ?>
						<div class="navbar-brand">
							<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
								<?php echo $img_html; ?>
								<?php bloginfo( 'name' ); ?>
							</a>
						</div>
					
					<?php endif; ?>
					
					<div class="dms-header-info dms-header-info_desktop">
						<div class="dms-header-info__text1">
							<?php echo \DMS\Helper\Utils::get_option( 'header_text1', '' ) ?>
						</div>
						<div class="dms-header-info__text2">
							<?php echo \DMS\Helper\Utils::get_option( 'header_text2', '' ) ?>
						</div>
						<div class="dms-header-info__text3">
							<?php echo \DMS\Helper\Utils::get_option( 'header_text3', '' ) ?>
						</div>
					</div>
				
				</div>
				
				<div class="navbar-funcs">
					
					<?php \DMS\Helper\Front::the_lang_select(); ?>
					
					<a href="#contact" class="callback-link"><?php _e( 'Обратный звонок', 'dms' ) ?></a>
					
					
					<?php
					
					$is_in_account_page = is_page( 'account' );
					
					if ( ! is_user_logged_in() ) {
						$account_url      = site_url( '/account' );
						$account_js_class = ' js-dms-account';
						$account_btn_text = __( 'Личный кабинет', 'dms' );
					} else {
						$account_url      = $is_in_account_page ? wp_logout_url( site_url() ) : site_url( '/account' );
						$account_js_class = '';
						$account_btn_text = $is_in_account_page ? __( 'Выйти', 'dms' ) : __( 'Личный кабинет', 'dms' );
					}
					?>
					
					<a href="<?php echo $account_url ?>" class="btn-arrow <?php echo $account_js_class ?>">
						<?php echo $account_btn_text ?>
						<div class="arrow-box">
							<i class="arrow-right"></i>
						</div>
					</a>
					
					<button class="menu-button" type="button">
						<span class="navbar-toggler-icon"></span>
					</button>
				
				</div>
			
			</nav>
		
		</div>
	
	</header>
	
	<section class="main-nav-section">
		
		<button class="menu-button" type="button">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		
		<div class="main-nav-brand">
			<?php echo $img_html; ?>
		</div>
		
		<div class="menu-avatar-box">
			<?php
			$user_photo_id = \DMS\Helper\Utils::get_user_meta( $user_id, 'dms--user_ava', 0 );
			if ( $user_photo_id ) {
				\DMS\Helper\Media::the_img(
					array( 'data-width' => 80, 'data-height' => 80, 'class' => 'profile-ava-img' ),
					array( 'attachment_id' => $user_photo_id )
				);
			}
			?>
		
		</div>
		
		<?php if ( has_nav_menu( 'header_menu' ) ) : ?>
			
			<nav id="main-nav" class="navigation-menu">
				
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header_menu',
						'menu_class'     => 'mobile-menu',
					)
				);
				?>
			
			</nav>
			
			<div class="navbar-funcs2">
				<a href="#contact" class="callback-link"><?php _e( 'Обратный звонок', 'dms' ) ?></a>
				<?php \DMS\Helper\Front::the_lang_list(); ?>
			</div>
			
			<div class="dms-menu-info-box">
				<div class="dms-menu-info">
					<div class="dms-menu-info__text1">
						<?php echo \DMS\Helper\Utils::get_option( 'header_text1', '' ) ?>
					</div>
					<div class="dms-menu-info__text2">
						<?php echo \DMS\Helper\Utils::get_option( 'header_text2', '' ) ?>
					</div>
					<div class="dms-menu-info__text3">
						<?php echo \DMS\Helper\Utils::get_option( 'header_text3', '' ) ?>
					</div>
				</div>
			</div>
		
		<?php endif; ?>
	
	</section>
	

