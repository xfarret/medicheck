jQuery(document).ready(function() {
    // Récupère le div qui contient la collection de tags
    var collectionHolder = jQuery('table.recipients');

    // ajoute un lien « add a tag »
    var $addTagLink = jQuery('<a href="#" class="add_recipient_link">Ajouter un récipient</a>');
    var $newLinkLi = jQuery('<li></li>').append($addTagLink);

    // ajoute l'ancre « ajouter un tag » et li à la balise ul
    collectionHolder.append($newLinkLi);

    $addTagLink.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
        addTagForm(collectionHolder, $newLinkLi);
    });
});


function addTagForm(collectionHolder, $newLinkLi) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);
    $newForm = jQuery(newForm);
    $newForm.find('div').addClass('form-group row');
    $newForm.find(':input').addClass('form-control');

    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un tag"
    var $newFormLi = jQuery('<li></li>').append($newForm);
    $newLinkLi.before($newFormLi);
}