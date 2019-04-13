<?php
$img      = \DMS\Helper\Utils::get_option( 'logo_img', 0 );
$img_html = ! empty( $img['url'] ) ? '<img src="' . esc_url( $img['url'] ) . '" alt="DM Solutions">' : '';
?>


<footer id="footer" class="page-footer">
	
	<div class="footer4c ">
		<div class="container">
			<div class="row">
				
				<div class="col-lg-3 col-md-6  d-md-none d-lg-none footer-brand">
					<?php echo $img_html; ?>
				</div>
				
				<div class="col-lg-3 col-md-6 d-none d-md-block order-1 order-lg-1">
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
				
				<div class="col-lg-3 col-md-6 d-none d-md-block order-3 order-lg-2">
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
				
				<div class="col-lg-3 col-md-6 order-2 order-lg-3">
					<div class="footer_box1">
						<?php echo \DMS\Helper\Utils::get_option( 'footer_box1', '' ) ?>
					</div>
				</div>
				
				<div class="col-lg-3 col-md-6 order-4 order-lg-4">
					<div class="footer_box2">
						<?php echo \DMS\Helper\Utils::get_option( 'footer_box2', '' ) ?>
					</div>
				</div>
			
			</div>
		</div>
	</div>
	
	<div id="bottom-bar" class="bottom-bar">
		<div class="container-fluid">
			<div class="row align-items-center">
				<div class="col-md-12">
					<div class="row align-items-center">
						<div class="col-md-6 order-2 order-md-1 copyright">
							<?php echo \DMS\Helper\Utils::get_option( 'bottom_bar_text' ); ?>
						</div>
						<div class="col-md-6 order-1 order-md-2 dev-logo">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/opex.svg' ?>" alt="opex">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</footer>

</div>


<div id="dms-login-popup-overlay" class="dms-popup-overlay">
	<div class="dms-login-popup dms-popup">
		<a href="#" class="dms-login-popup-close dms-popup-close">X</a>
		
		<div class="dms-popup-box">
			<header class="dms-popup-header">
				<i class="fa fa-user-circle-o"></i>
				<div class="h1"><?php _e( 'Вход', 'dms' ) ?></div>
			</header>
			<div class="dms-popup-main">
				<div class="inner-main">
					<form method="POST" action="">
						<div class="field">
							<input type="email" name="email" placeholder="<?php _e( 'E-mail', 'dms' ) ?>"/>
						</div>
						<div class="field">
							<input type="password" name="pass" placeholder="<?php _e( 'Password', 'dms' ) ?>"/>
						</div>
						
						<input type="submit" class="js-dms-account-login" value="<?php _e( 'Войти', 'dms' ) ?>"/>
					</form>
					<div class="error-box"></div>
					
					<div class="links-login">
						<a href="#" class="js-dms-account-forgot-trigger"><?php _e( 'Забыли пароль?', 'dms' ) ?></a>
						<a href="#" class="js-dms-account-reg-trigger"><?php _e( 'Регистрация', 'dms' ) ?></a>
					</div>
				</div>
			</div>
		</div>
	
	</div>
</div>


<div id="dms-forgot-popup-overlay" class="dms-popup-overlay">
	<div class="dms-forgot-popup dms-popup">
		<a href="#" class="dms-forgot-popup-close dms-popup-close">X</a>
		
		<div class="dms-popup-box">
			<header class="dms-popup-header">
				<i class="fa fa-user-circle-o"></i>
				<div class="h1"><?php _e( 'Восстановить', 'dms' ) ?></div>
			</header>
			<div class="dms-popup-main">
				<div class="inner-main">
					<form method="POST" action="">
						<div class="field">
							<input type="email" name="email" required placeholder="<?php _e( 'E-mail', 'dms' ) ?>"/>
						</div>
						
						<input type="submit" class="js-dms-account-forgot" value="<?php _e( 'Отправить', 'dms' ) ?>"/>
					
					</form>
					<div class="error-box"></div>
				</div>
			</div>
		</div>
	
	</div>
</div>


<div id="dms-reg-popup-overlay" class="dms-popup-overlay">
	<div class="dms-reg-popup dms-popup">
		<a href="#" class="dms-reg-popup-close dms-popup-close">X</a>
		
		<div class="dms-popup-box">
			<header class="dms-popup-header">
				<i class="fa fa-user-circle-o"></i>
				<div class="h1"><?php _e( 'Регистрация', 'dms' ) ?></div>
			</header>
			<div class="dms-popup-main">
				<form method="POST" action="">
					<div class="upper">
						<div class="field">
							<input type="email" name="email" required placeholder="<?php _e( 'E-mail', 'dms' ) ?>">
						</div>
						<div class="field">
							<input type="password" name="pass1" required placeholder="<?php _e( 'Пароль', 'dms' ) ?>">
						</div>
						<div style="visibility: hidden"></div>
						<div class="field">
							<input type="password" name="pass2" required placeholder="<?php _e( 'Повторите пароль', 'dms' ) ?>">
						</div>
					</div>
					<hr/>
					<div class="lower">
						<div class="field">
							<input type="text" name="fio" required placeholder="<?php _e( 'ФИО', 'dms' ) ?>">
						</div>
						<div class="field">
							<input type="text" name="reg_code" required placeholder="<?php _e( 'ЕГРПОУ', 'dms' ) ?>">
						</div>
						<div class="field">
							<input type="text" name="position" required placeholder="<?php _e( 'Должность', 'dms' ) ?>">
						</div>
						<div class="field">
							<input type="text" name="company_name" required placeholder="<?php _e( 'Название компании', 'dms' ) ?>">
						</div>
						<div class="field">
							<input type="tel" name="phone" required placeholder="<?php _e( 'Телефон', 'dms' ) ?>">
						</div>
						<div class="field">
							<input type="text" name="company_address" required placeholder="<?php _e( 'Юр. адрес', 'dms' ) ?>">
						</div>
					</div>
					<div class="g-recaptcha" data-sitekey="your_site_key"></div>
					<br/>
					<input type="submit" class="js-dms-account-reg" value="<?php _e( 'Зарегистрироваться', 'dms' ) ?>">
				</form>
				<div class="error-box"></div>
			</div>
		</div>
	
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
