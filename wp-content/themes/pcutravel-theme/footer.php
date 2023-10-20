<footer>
    <div id="footer-main" class="container">
        <div class="row justify-content-center">
            <div class="col-11 col-lg-5">
                <img src="https://pcustoragewordpress.blob.core.windows.net/wordpress/pcu-travel-logo-color.svg" alt="PCU Logo">
                <div class="details">
                    <div class="boxcrush_social">
                        <a href="https://www.facebook.com/PointComfortUnderwriters/" title="facebook" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.youtube.com/channel/UC1tqzmNiJGzWWhZjRiDBMBA" title="youtube" target="_blank">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://twitter.com/PointComfort_Tr" title="twitter" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.pinterest.com/pointcomforttravel/" title="pinterest" target="_blank">
                            <i class="fab fa-pinterest"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/point-comfort-underwriters/" title="linkedin" target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="https://www.instagram.com/triptimeinsurance/" title="instagram" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                    <div class="content-block container">
                        <div>
                            <p style="text-align: justify">
                                <strong>POINT COMFORT UNDERWRITERS</strong>
                                &nbsp
                                <br>
                                PCU is a healthcare management and administration company providing cost-saving solutions and insurance for international travelers, multi-national organizations, government sponsored programs and other international establishments.  PCU holds agreements with several well-known insurers and as such, has the authority to quote, bind and administer a range of insurance products on their behalf.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">

            </div>
            <div class="col-11 col-lg-5">
                <nav>
                    <ul class="nav nav-sitemap">
                        <li class="nav-item">
                            <a class="nav-link top-level" href="#" target="_self"><b>INSURANCE</b></a>
                            <?php
                                wp_nav_menu(array(
                                    'menu'              => 'footer-menu1',
                                    'theme_location'    => 'footerMenuLocation1',
                                    'menu_class'        => 'nav flex-column'
                                ));
                            ?>
                        </li>
					</ul>
					<ul class="nav nav-sitemap">
                        <li class="nav-item">
                            <a class="nav-link top-level" href="#" target="_self"><b>RESOURCES</b></a>
                            <?php
                                wp_nav_menu(array(
                                    'menu'              => 'footer-menu2',
                                    'theme_location'    => 'footerMenuLocation2',
                                    'menu_class'        => 'nav flex-column'
                                ));
                            ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div id="footer-sub">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg text-lg-left">
                    <div class="content-block container">
                        <div>Point Comfort is a registered trademark of Point Comfort ®2019</div> 
                    </div>
                </div>
                <div class="col-lg">
                    <nav>
                    <?php
                        wp_nav_menu(array(
                            'menu'              => 'footer-legal-menu',
                            'theme_location'    => 'footerSubLegal',
                            'menu_class'        => 'nav'
                        ));
                    ?>
                    </nav>
                </div>
                <div class="col-lg text-lg-right">
<!--                     <a href="#">Website Design</a> by ..... -->
                </div>
            </div>
        </div>
    </div> 
</footer>

<?php wp_footer(); ?>

<div class="modal fade" id="noActionSpinner" tabindex="-1" role="dialog" aria-label="Working..." aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content"> 
            <div class="modal-body"> 
                <div class="d-flex justify-content-center"> 
                    <img src="<?php echo get_theme_file_uri('/images/spinner.gif?package=PointComfort'); ?>" height="60" /> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 
<div class="modal fade" id="userLoginSpinner" tabindex="-1" role="dialog" aria-label="Working..." aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content"> 
            <div class="modal-body"> 
                <div class="d-flex justify-content-center"> 
                    <img src="<?php echo get_theme_file_uri('/images/spinner.gif?package=PointComfort'); ?>" height="60" /> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 
<div class="modal fade" id="userForgotPasswordSpinner" tabindex="-1" role="dialog" aria-label="Working..." aria-hidden="true" data-backdrop="static" data-keyboard="false"> 
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content"> 
            <div class="modal-body"> 
                <div class="d-flex justify-content-center"> 
                    <img src="<?php echo get_theme_file_uri('/images/spinner.gif?package=PointComfort'); ?>" height="60" /> 
                </div> 
            </div> 
        </div> 
    </div> 
</div> 
<div class="modal fade" id="userLoginMessage" tabindex="-1" role="dialog" aria-labelledby="userLoginMessageTitle" aria-hidden="true"> 
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content"> 
            <div class="modal-body"> <span class="message">Login failed.</span></div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button> 
            </div> 
        </div> 
    </div> 
</div> 
<div class="modal fade" id="userLoginDecisionModal" tabindex="-1" role="dialog" aria-labelledby="userLoginDecisionTitle" aria-hidden="true"> 
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title" id="userLoginDecisionTitle">Select Portal</h5> 
            </div> 
            <div class="modal-body"> 
                <form></form> 
            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary left" data-dismiss="modal">Cancel</button> 
                <button type="button" class="btn btn-primary left" id="selectLoginPortal">Go to Portal</button> 
            </div> 
        </div> 
    </div> 
</div> 
<div class="modal fade" id="userForgotPasswordDecisionModal" tabindex="-1" role="dialog" aria-labelledby="userForgotPasswordDecisionTitle" aria-hidden="true"> 
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title" id="userForgotPasswordDecisionTitle">Select Portal</h5> 
            </div> 
            <div class="modal-body"> <form></form> </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary left" data-dismiss="modal">Cancel</button> 
                <button type="button" class="btn btn-primary left" id="selectForgotPasswordPortal">Go to Portal</button> 
            </div> 
        </div>
    </div> 
</div> 
<div class="modal fade" id="ieWarningMessageModal" tabindex="-1" role="dialog" aria-labelledby="ieWarningMessageMessageTitle" aria-hidden="true"> 
    <div class="modal-dialog modal-dialog-centered" role="document"> 
        <div class="modal-content"> 
            <div class="modal-body"> 
                <span class="message">Internet Explorer is not supported. Please use another browser.</span> 
            </div> 
            <div class="modal-footer"> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button> 
            </div> 
        </div> 
    </div> 
</div> 
<script>
        if (navigator.appName == 'Microsoft Internet Explorer' || !!(navigator.userAgent.match(/Trident/) || navigator.userAgent.match(/rv:11/)) || (typeof $.browser !== "undefined" && $.browser.msie == 1))
            $('#ieWarningMessageModal').modal('show');
</script>

</body>
</html>