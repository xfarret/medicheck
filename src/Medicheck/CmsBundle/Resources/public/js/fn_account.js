jQuery(document).ready(function() {
//    jQuery('.videoGalleryDel').on('click', deleteVideoGallery);
//    //jQuery('.videoGalleryEncoderManual').on('click', startEncoderManually);
//    jQuery('.wallToggle').on('click', toggleVideoWall);

});

function addRecipient(form) {
    var $this = jQuery(form);

    jQuery.ajax({
        url: $this.attr('action'), // le nom du fichier indiqué dans le formulaire
        type: $this.attr('method'), // la méthode indiquée dans le formulaire (get ou post)
        data: $this.serialize(), // je sérialise les données (voir plus loin), ici les $_POST
        success: function(html) { // je récupère la réponse du fichier PHP
            alert(html); // j'affiche cette réponse
        },
        error: function(html) {
            alert(html);
        }
    });
    return false;
}