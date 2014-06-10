jQuery(function () {
    jQuery("td").dblclick(function () {
        var OriginalContent = jQuery(this).text();

        jQuery(this).addClass("cellEditing");
        jQuery(this).html("<input type='text' value='" + OriginalContent + "' />");
        jQuery(this).children().first().focus();

        jQuery(this).children().first().keypress(function (e) {
            if (e.which == 13) {
                var newContent = jQuery(this).val();
                jQuery(this).parent().text(newContent);
                jQuery(this).parent().removeClass("cellEditing");
            }
        });

        jQuery(this).children().first().blur(function(){
            jQuery(this).parent().text(OriginalContent);
            jQuery(this).parent().removeClass("cellEditing");
        });
    });
});