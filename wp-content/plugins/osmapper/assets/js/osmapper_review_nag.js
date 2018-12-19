/**
 * Author : Mateusz Grzybowski
 * grzybowski.mateuszz@gmail.com
 */
(function ($) {
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        // console.log(exdays);
    }

    $(document).on('click', '.ba_map_notice .notice-dismiss, .ba_map_notice .dismiss-nag', function (e) {
        e.preventDefault();


        // alert('clicked');
        setCookie('osmapper_review_nag', 'hide', 21);
        $('.ba_map_notice').remove();


    });


})(jQuery);