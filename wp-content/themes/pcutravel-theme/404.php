<?php
get_header();
?>
<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/hands-image.png') ?>" alt="Multiple Handshakes">
    </div>
    <div id="headline" class="page-banner__content container">
        <div class="row justify-content-center align-items-end">
            <div class="col-md col-md-10">
                <H1 class="page-banner__title">404</H1>
            </div>
        </div>    
    </div>
</div>
<!-- Brand Blocks Section -- ACF -->
<section class="brand-blocks container">
    <div class="row justify-content-center">
    <h5>The resource you are looking for has been removed, had its name changed, or is temporarily unavailable.</h5>
        <div class="col-md col-md-10" style="opacity: 0.4">
        <hr>
        <p style="text-align: center"><a href="<?php echo esc_url(get_site_url()); ?>">Main Page</a></p>
        <br>
            <div class="row text-center justify-content-center">
            <p style="text-align: center;"><strong>Join our family of travelers.<br>
Select an option below to get started!</strong><br>
This is your time. Make the most of it, and buy coverage that suits you.</p>
            </div>
            <div class="row blocks justify-content-center">
                <div class="col-md col-lg-6 col-xl-4">
                    <div class="brand-card-container">
                        <div class="brand-card">
                            <div class="face block">
                                <a class="triptime text-center" href="<?php echo esc_url(site_url('/insurance/triptime-insurance')); ?>" target="_blank">
                                    <img src="<?php echo get_theme_file_uri('/images/trip-time-logo-h.png'); ?>" alt="Trip Time Insurance">
                                    <p style="text-align: center;"><strong>International Travel Insurance</strong></p>
<p style="text-align: center;">Cover yourself and your assets.</p>
                                </a>
                            </div>
                            <div class="face block back triptime">
                                <a href="<?php echo esc_url(site_url('/insurance/triptime-insurance')); ?>" target="_blank">
                                    <p style="text-align: center;">
                                        - VACATION - HOLIDAY -<br>
                                        - CRUISE - TOUR -<br>
                                        - ADVENTURE - ECO -<br>
                                        - VOLUNTEER - TRAVEL -
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <DIV CLASS="col-md col-lg-6 col-xl-4">
                    <div class="brand-card-container">
                        <div class="brand-card">
                            <div class="face block">
                                <a class="anytime text-center" href="<?php echo esc_url(site_url('/insurance/anytime-insurance')); ?>" target="_blank">
                                    <img src="<?php echo get_theme_file_uri('/images/anytime-logo-h.png'); ?>" alt="Any Time Insurance">
                                    <p style="text-align: center;"><strong>The plan that's there for you, year-round.</strong></p>
                                    <p style="text-align: center;">Up in the air a lot? Your medical coverage shouldn't be.</p>
                                </a>
                            </div>
                            <div class="face block back anytime">
                                <a href="<?php echo esc_url(site_url('/insurance/anytime-insurance')); ?>" target="_blank">
                                    <p></p>
                                </a>
                            </div>
                        </div>
                    </div>
                </DIV>
            </div>
        </div>
    </div> 
</section>

<?php 

    get_footer();
?>