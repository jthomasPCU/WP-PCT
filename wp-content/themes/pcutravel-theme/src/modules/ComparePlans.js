import $ from 'jquery';

class ComparePlans {
    constructor() {
        $(function () {
            $(".js-toggle-compare").on("click", togglePlans);
            function togglePlans(e) {
                $(".js-packages").toggle("slow");
                if ($('.icon-double-angle-down').hasClass('open')) {
                    $('.icon-double-angle-down').removeClass('open');
                } else {
                    $('.icon-double-angle-down').addClass('open');
                }
            }
        });
    }
};

export default ComparePlans;