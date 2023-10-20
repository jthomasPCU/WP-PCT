function is_page($pageid) {
    if (jQuery('body').hasClass('page-id-'+$pageid)) { return true; } else { return false; }
};

// Only excuted on start a quote page
if (is_page(12)) {
jQuery(document).ready(function ($) {
    
    if (purchasePathApp) {
        var showPurchasePathAtStep = function (step) {
            if (!step)
                step = 1;
            $('#purchase-path').fadeIn(500);
            $('.indicators').fadeIn(500, function () {
                purchasePathApp.showPurchasePathStep(step);
                $('#purchase-path-spinner').modal('hide');
            });
        };

        var payload = $('#Payload').val();
        var appId = $('#SavedApplicationID').val();
        var planId = $('#SelectedPlan').val();
        var productId = $('#ProductID').val();
        if (payload) { // from the quote engine
			payload = JSON.parse(decodeURIComponent(payload));
            purchasePathApp.initWithPayload(showPurchasePathAtStep);
		} else if (appId) // from a saved app
            purchasePathApp.initWithApplication(showPurchasePathAtStep);
        else if (planId) // with a specific plan
            purchasePathApp.initWithSelectedPlan(showPurchasePathAtStep);
        else if (productId) // with a specific product
            purchasePathApp.initWithProductId(showPurchasePathAtStep);
        else // ya basic
            purchasePathApp.init(showPurchasePathAtStep);
    }

    PointComfort.TripAPI = 'https://pcu-api.azurewebsites.net';
    // override the Sitefinity setting with the widget setting

    //------------------------------------------------
    // remove this once we remove top nav from the PP
    function checkPPZindex() {
        if ($(window).scrollTop() < 73) {
            $(".overview-wrapper").css('z-index', '1');
        } else {
            $(".overview-wrapper").css('z-index', '99999');
        }
    }

    $(window).scroll(function(event) {
        checkPPZindex();
    });

    checkPPZindex();
    //------------------------------------------------

});
   }