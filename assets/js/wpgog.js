/* -------------------------------- *
 *   Ultimate Tab for WooCommerce  	*
 * -------------------------------- */
jQuery(document).ready(function($) {

    //Add More Project Update Field
    $('#addunlimitedtabs').on('click', function(e) {
        e.preventDefault();
        var ultimate_fields = $('.unlimited_tab_group').html();
        $('#unlimited_tabs').append( ultimate_fields );
        countRemovesBtn('.removeUnlimitedTabs');
    });


    // Remove Tabs
    $('body').on('click', '.removeUnlimitedTabs', function(e) {
        e.preventDefault();
        $(this).closest('.unlimited_tab_field_copy').html('');
        countRemovesBtn('.removeUnlimitedTabs');
    });
    countRemovesBtn('.removeUnlimitedTabs');

    function countRemovesBtn(btn) {
        var rewards_count = $(btn).length;
        if ( rewards_count > 1 ) {
            $(btn).show();
        } else {
            $(btn).hide();
            if (btn == '.removeUnlimitedTabs') {
                $('.unlimited_tab_group').show();
            }
        }
        $(btn).first().hide();
    }

});
