jQuery(document).ready(function() {
    // Récupère le div qui contient la collection de tags
    collectionHolder = jQuery('table.recipients');

    // ajoute un lien « add a tag »
    $addRecipientLink = jQuery('<a href="#" class="add_recipient_link">Ajouter un récipient</a>');

    // ajoute l'ancre « ajouter un tag » et li à la balise ul
    collectionHolder.after($addRecipientLink);

    $addRecipientLink.on('click', function(e) {
        // empêche le lien de créer un « # » dans l'URL
        e.preventDefault();

        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
        addRecipientForm(collectionHolder);
    });
});

var collectionHolder = null;
var $addRecipientLink = null;

function addRecipientForm(collectionHolder) {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder.attr('data-prototype');

    // Remplace '__name__' dans le HTML du prototype par un nombre basé sur
    // la longueur de la collection courante
    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);
    $newForm = jQuery(newForm);
    $newForm.find('div').addClass('form-group row');
    $newForm.find(':input').addClass('form-control');

    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter un tag"
    collectionHolder.find('tbody').append($newForm);
}

function addRecipientRow() {
    // Récupère l'élément ayant l'attribut data-prototype comme expliqué plus tôt
    var prototype = collectionHolder.attr('row-prototype');

    var $addRecipientDom = jQuery("#new-recipient");
    var $newRecipient = $addRecipientDom;
    $newRecipient.find("td").each(function(index) {
        $this = jQuery( this );
        $input = $this.children('input:first');
        value = $input.val();
        $this.empty();
        $this.append(value);
    });
    $newRecipient.removeAttr('id');

    // ajout de la nouvelle entrée
    collectionHolder.find('tbody').children(':last').after($addRecipientDom);

    return false;
}