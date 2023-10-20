<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-4KRTFNCZH8"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-4KRTFNCZH8');
	</script>
		
		<meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>

    <script>
        PointComfort.API = 'https://pcu-portal-api.azurewebsites.net';
        PointComfort.TripAPI = 'https://pcu-api.azurewebsites.net';
        PointComfort.Errors.LoginError = 'An error occurred. Please try again.';
        PointComfort.Errors.LoginFailed = 'Login failed.';
        PointComfort.Errors.TokenFailed = 'An error occurred communicating with the portal. Please contact Point Comfort support.';
        PointComfort.Errors.EmailNotFound = 'Email not found.';
    </script> 
    <script src="https://www.dwin1.com/19038.js" type="text/javascript" defer=""></script>

<!-- <script type="text/javascript"> 
	(function() {
		function deleteCookie(cookieName) {
		document.cookie = cookieName + '=;expires=Mon Jan 01 1900 00:00:00 ; path=/';
		}

		function loadAndTrack(canTrack) {
			if (!canTrack) {
				deleteCookie('_ga');
				deleteCookie('_gat');
				deleteCookie('_gid');
				return;
			}
	
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	ga('create', 'UA-145463601-6', 'auto');
	ga('send', 'pageview');
	}
	
	if (window.TrackingConsentManager) {
	TrackingConsentManager.addEventListener('ConsentChanged', loadAndTrack);
	loadAndTrack(TrackingConsentManager.canTrackCurrentUser());
	}
	else {
	loadAndTrack(true);
	}
	})(); 
</script>
		 -->
    </head>
	
	<!-- <script type="text/javascript">
        var stylesheet_directory_uri = "<?php echo get_stylesheet_directory_uri(); ?>";
    </script> -->

    <body <?php body_class(); ?>>
        <!-- Login Panel - Changed -->
        <!-- <div id="login-panel" class="login-panel">
            <div class="controls">
                <button class="log-toggle">
                    <i class="fas fa-globe-americas open-action"></i>
                    <i class="fas fa-times close-action"></i>
                    <span class="open-action">Login</span>
                    <span class="close-action">Close</span>
                </button>
            </div>
            <div class="panel">
                <P class="heading">
                    Looking to login to one of our portals?
                    <br>
                    You're in the right place.
                </P>
                <img class="logo" src="<?php echo get_theme_file_uri('/images/pcu-logo-icon.svg')?>">
                <P class="welcome"><strong></strong><br></P>
                <P class="title"></P>
                <form id="login-form" action method="post">
                    <label for="panel-username">Email</label>
                    <input type="text" id="panel-username" name="username">
                    <label for="panel-password">Password</label>
                    <input type="password" id="panel-password" name="password">
                    <input type="submit" value="Login">
                </form>
                <form id="forgot-password-form">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email">
                    <input type="submit" value="Submit">
                </form>
                <P class="forgot-password">
                    <a href id="forgot-password-link">Forgot password?</a>
                </P>
                <P class="login">
                    <a href id="login-link">Already have an account? Login.</a>
                </P>
                <P class="register">Not a member?
                    <a href="#">Sign up here.</a>
                </P>
                <P class="cancel">
                    <a href="#" class="cancel-button">
                        <i class="fas fa-times close-action"></i>
                        Close
                    </a>
                </P>
            </div>
        </div>  -->
        <div class="login-panel">
    <input id="UsePortalLogin" name="UsePortalLogin" type="hidden" value="True" />
    <input id="PortalLoginURL" name="PortalLoginURL" type="hidden" value="/home/LoginWithToken/" />
    <div class="controls">
        <button class="toggle">
            <svg class="open-action">
                <use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#globe-americas'); ?>"></use>
            </svg>
            <svg class="close-action">
                <use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#times'); ?>"></use>
            </svg>
            <span class="open-action">Login</span>
            <span class="close-action">Close</span>
        </button>
    </div>
    <div class="panel">
        <p class="heading">
            <a style="color:#424148; text-decoration:underline;" href="https://pcyou.pointcomfort.com/"><strong>Click here to login to PCYOU</strong></a>
        </p>
        <img class="logo" src="<?php echo get_theme_file_uri('/images/pcu-logo-icon.svg'); ?>" />
        <p class="welcome">
            <strong>PCYOU</strong><br />
            
        </p>
        <p class="title">
            Login to access member resources.
        </p>
        <form id="login-form"
              action="" method="post">
            <label for="panel-username">Email</label>
            <input type="text" id="panel-username" name="username" />
            <label for="panel-password">Password</label>
            <input type="password" id="panel-password" name="password" />
            <input type="submit" value="Login" />
        </form>
        <form id="forgot-password-form"
              action="" method="post">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" />
            <input type="submit" value="Submit" />
        </form>
        <p class="forgot-password">
            <a href="" id="forgot-password-link">Forgot password?</a>
        </p>
        <p class="login">
            <a href="" id="login-link">Already have an account? Login.</a>
        </p>
        <p class="register">
            Not a member?
            <a href="/register/">Sign up here.</a>
        </p>
        <p class="cancel">
            <a href="#" class="cancel-button">
                <svg>
                    <use xlink:href="<?php echo get_theme_file_uri('/images/sprites/solid.svg#times') ?>"></use>
                </svg>
                Close
            </a>
        </p>
    </div>
</div>

        <div id="topbar" class="fixed-top">
            <header class="site-header" id="header">
                <div class="container">
                    <?php if (!is_page('12')) { ?>

                    <nav class="navbar navbar-expand-lg navbar-dark justify-content-between" id="navbar">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" 
                                    data-target="#navbarCollapse" aria-controls="navbarCollapse" 
                                    aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon" id="navbar-toggler-icon"></span>
                    </button>
                    <a href="<?php echo esc_url(site_url()); ?>">
                        <img class="site-header__logo" id="logo" src="<?php echo get_theme_file_uri( '/images/pcu-travel-logo-white.svg' ) ?>" />
                    </a>
                            <div class="container">
                                <?php
                                    wp_nav_menu([
                                    'menu'            => 'primary-top',
                                    'theme_location'  => 'headerMenuLocation',
                                    'container'       => 'div',
                                    'container_id'    => 'navbarCollapse',
                                    'container_class' => 'collapse navbar-collapse',
                                    'menu_id'         => false,
                                    'menu_class'      => 'nav navbar-nav mr-auto',
                                    'depth'           => 2,
                                    'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                                    'walker' => new WP_Bootstrap_Navwalker(),
                                    ]);
                                ?>
                                </div>
                    </nav>

            <?php } else { ?>
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-4">
                            <a href="<?php echo esc_url(site_url()); ?>">
                                <img id="default-producer" class="site-header__logo logo hidden" src="https://pcustoragewordpress.blob.core.windows.net/producer-logos/pcu-travel-logo-color.svg"/>
                            </a>
                            <img id="producer-logo" class="site-header__logo logo hidden" src=""/>
                        </div>

                        <div id="producer-details" class="col-12 col-lg-8 text-center text-lg-right mt-3 mt-lg-0 producer-details">
                        </div>
                    </div>

            <?php } ?>

        </div>


    </div>
    </header>
</div>
