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
					
					<div class="lang-selector">
						<select name="lang-select" id="lang-select" class="lang-select">
							<option value="RU" selected>RU</option>
							<option value="UA">UA</option>
							<option value="EN">EN</option>
						</select>
					</div>
					
					<a href="#" class="callback-link"><?php _e('Обратный звонок', 'dms') ?></a>
					
					<a href="<?php echo site_url('/account') ?>" class="btn-arrow <?php if ( ! is_user_logged_in() ) echo ' js-dms-account' ?>"><?php _e('Личный кабинет', 'dms') ?>
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
		
		<div class="menu-avatar-box"
			 style="background-image: url(<?php echo get_template_directory_uri() . '/assets/images/userpic.jpg' ?>);">
		</div>
		
		<?php if ( has_nav_menu( 'header_menu' ) ) : ?>
			
			<nav id="main-nav" class="navigation-menu">
				
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header_menu',
						'menu_class'     => 'mobile-menu'
					)
				);
				?>
				
			</nav>
			
			<div class="navbar-funcs2">
				<a href="#" class="callback-link"><?php _e('Обратный звонок', 'dms') ?></a>
				<div class="lang-selector-list" >
					<ul class="lang-list">
						<li><span>RU</span></li>
						<li><a href="#">UA</a></li>
						<li><a href="#">EN</a></li>
					</ul>
				</div>
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
	
	<section id="composer-header" class="bg-dark">
		<div class="container">
			<?php echo DMS()->View->load_composer_layout( 'header' ); ?>
		</div>
	</section>
