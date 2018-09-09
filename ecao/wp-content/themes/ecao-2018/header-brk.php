<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
	
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
	
	<!-- Latest compiled and minified CSS -->
	
	<!--[if ltIE9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
	<!--<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>-->
	<script src="<?php bloginfo('template_directory'); ?>/js/script.js"></script>
	
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header>

	</header>
	
	<nav class="navbar navbar-fixed-top">
		<div class="container">

			<div class="col-md-10 col-sm-11 col-xs-11" id="header-logo-div">
				<div class="navbar-header"><a href="<?php echo get_option('home'); ?>/"><h3 style="padding-bottom:0px">the Exceptional Creative Achievement Organization</h3></a></div>
			</div>
			<!--<span class="float-right" id="login-field">
				<a href="login.php">sign up</a>
				<a href="login.php">log in</a>
			</span>-->
			<div class="col-md-2 col-sm-1 col-xs-1">
				<div class="float-right" id="header-fields">
					<div class="float-right" id="header-field">
						<ul ><h4 style="padding-top:0px;padding-bottom:0px;color:GhostWhite"><span id="header-menu"><a href="" style="color:GhostWhite;font-weight:600;">ABOUT US</a> <a href="" style="color:GhostWhite;font-weight:600">MEMBERSHIP</a> <a href="" style="color:GhostWhite;font-weight:600">SPONSORSHIP</a><a href="#" style="color:GhostWhite;padding-right:0px" id="menu-toggle"><img src="<?php bloginfo('template_directory'); ?>/images/ecao-icon.png" style="width:24px;height:auto;margin-top:-4px"></span> <img src="<?php bloginfo('template_directory'); ?>/images/img-toggle.png" style="width:20px;height:auto"></a></h4></ul>
					</div>
				</div>
			</div>
		</div>
		<ul id="menu-main">
			<!--<li><a href="/about-us/">About Us</a><a href="#" class="arrow float-right"><img src="<?php bloginfo('template_directory'); ?>/images/down-arrow.png" style="width: 15px; height: auto"></a>
				<ul id="sub-menu">
					<li><a href="why.php">Why another society?</a>
					<li><a href="why.php">How we differ</a>
				</ul>
			<li><a href="requirements.php">Membership Requirements</a><a href="#" class="arrow2 float-right"><img src="<?php bloginfo('template_directory'); ?>/images/down-arrow.png" style="width: 15px; height: auto"></a>
				<ul id="sub-menu2">
					<li><a href="why.php">Membership tiers</a>
				</ul>
			<li><a href="ScoringGeneral.php">Progression</a>
			<li><a href="links.php">Related Information</a>
			<li><a href="login.php">Log in</a>-->
			<?php wp_nav_menu( array(
				'theme_location' => 'main_menu' ,
				'menu' => 'Main Menu' ,
				'container' => 'ul' ,
				'walker' => new Add_button_of_Sublevel_Walker
			) ); ?>
		</ul>
	</nav>
	
