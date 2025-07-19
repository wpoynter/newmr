<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
	<![endif]-->
	<script> baseURL = "<?php echo get_site_url(); ?>"; </script>
	<?php wp_head(); ?>
	<?php fourwalls_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" role="banner">
			<div id="inner-header" class="content-width">
				<div id="logo" class="site-header"></div>
				<div id="links">
					<div id="donate"><a href="/donate/">Donate</a></div>
					<div id="sign-up"><a href="http://eepurl.com/hAnKA">Sign Up</a></div>
				</div>
				<div id="navbar" class="navbar">
					<nav id="site-navigation" class="navigation main-navigation" role="navigation">
						<h3 class="menu-toggle"><span class="dashicons dashicons-menu"></span></h3>
						<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'fourwalls' ); ?>"><?php _e( 'Skip to content', 'fourwalls' ); ?></a>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
						<?php get_search_form(); ?>
					</nav><!-- #site-navigation -->
				</div><!-- #navbar -->
			</div>
		</header>
		
		<div id="main" class="site-main">