(function ($) {
    "use strict";
    jQuery(document).ready(function () {
        $('#ic_venue_location').on('change', function () {
            let location = $(this).val();
            location = location.split(',');
            $('#ic_venue_lat').val(location[0]);
            $('#ic_venue_lng').val(location[1]);
        });
    });

})(jQuery);