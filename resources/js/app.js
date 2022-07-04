require('./bootstrap');

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.extend(true, $.fn.DataTable.defaults, {
    language: {
        "emptyTable": "Aucune donnée disponible dans le tableau",
        "loadingRecords": "Chargement...",
        "processing": "Traitement...",
        "aria": {
            "sortAscending": ": activer pour trier la colonne par ordre croissant",
            "sortDescending": ": activer pour trier la colonne par ordre décroissant"
        },
        "select": {
            "rows": {
                "_": "%d lignes sélectionnées",
                "1": "1 ligne sélectionnée"
            },
            "cells": {
                "1": "1 cellule sélectionnée",
                "_": "%d cellules sélectionnées"
            },
            "columns": {
                "1": "1 colonne sélectionnée",
                "_": "%d colonnes sélectionnées"
            }
        },
        "autoFill": {
            "cancel": "Annuler",
            "fill": "Remplir toutes les cellules avec <i>%d<\/i>",
            "fillHorizontal": "Remplir les cellules horizontalement",
            "fillVertical": "Remplir les cellules verticalement"
        },
        "searchBuilder": {
            "conditions": {
                "date": {
                    "after": "Après le",
                    "before": "Avant le",
                    "between": "Entre",
                    "empty": "Vide",
                    "not": "Différent de",
                    "notBetween": "Pas entre",
                    "notEmpty": "Non vide",
                    "equals": "Égal à"
                },
                "number": {
                    "between": "Entre",
                    "empty": "Vide",
                    "gt": "Supérieur à",
                    "gte": "Supérieur ou égal à",
                    "lt": "Inférieur à",
                    "lte": "Inférieur ou égal à",
                    "not": "Différent de",
                    "notBetween": "Pas entre",
                    "notEmpty": "Non vide",
                    "equals": "Égal à"
                },
                "string": {
                    "contains": "Contient",
                    "empty": "Vide",
                    "endsWith": "Se termine par",
                    "not": "Différent de",
                    "notEmpty": "Non vide",
                    "startsWith": "Commence par",
                    "equals": "Égal à",
                    "notContains": "Ne contient pas",
                    "notEnds": "Ne termine pas par",
                    "notStarts": "Ne commence pas par"
                },
                "array": {
                    "empty": "Vide",
                    "contains": "Contient",
                    "not": "Différent de",
                    "notEmpty": "Non vide",
                    "without": "Sans",
                    "equals": "Égal à"
                }
            },
            "add": "Ajouter une condition",
            "button": {
                "0": "Recherche avancée",
                "_": "Recherche avancée (%d)"
            },
            "clearAll": "Effacer tout",
            "condition": "Condition",
            "data": "Donnée",
            "deleteTitle": "Supprimer la règle de filtrage",
            "logicAnd": "Et",
            "logicOr": "Ou",
            "title": {
                "0": "Recherche avancée",
                "_": "Recherche avancée (%d)"
            },
            "value": "Valeur"
        },
        "searchPanes": {
            "clearMessage": "Effacer tout",
            "count": "{total}",
            "title": "Filtres actifs - %d",
            "collapse": {
                "0": "Volet de recherche",
                "_": "Volet de recherche (%d)"
            },
            "countFiltered": "{shown} ({total})",
            "emptyPanes": "Pas de volet de recherche",
            "loadMessage": "Chargement du volet de recherche...",
            "collapseMessage": "Réduire tout",
            "showMessage": "Montrer tout"
        },
        "buttons": {
            "collection": "Collection",
            "colvis": "Visibilité colonnes",
            "colvisRestore": "Rétablir visibilité",
            "copy": "Copier",
            "copySuccess": {
                "1": "1 ligne copiée dans le presse-papier",
                "_": "%ds lignes copiées dans le presse-papier"
            },
            "copyTitle": "Copier dans le presse-papier",
            "csv": "CSV",
            "excel": "Excel",
            "pageLength": {
                "-1": "Afficher toutes les lignes",
                "_": "Afficher %d lignes"
            },
            "pdf": "PDF",
            "print": "Imprimer",
            "copyKeys": "Appuyez sur ctrl ou u2318 + C pour copier les données du tableau dans votre presse-papier.",
            "createState": "Créer un état",
            "removeAllStates": "Supprimer tous les états",
            "removeState": "Supprimer",
            "renameState": "Renommer",
            "savedStates": "États sauvegardés",
            "stateRestore": "État %d",
            "updateState": "Mettre à jour"
        },
        "decimal": ",",
        "search": "Rechercher:",
        "datetime": {
            "previous": "Précédent",
            "next": "Suivant",
            "hours": "Heures",
            "minutes": "Minutes",
            "seconds": "Secondes",
            "unknown": "-",
            "amPm": [
                "am",
                "pm"
            ],
            "months": {
                "0": "Janvier",
                "2": "Mars",
                "3": "Avril",
                "4": "Mai",
                "5": "Juin",
                "6": "Juillet",
                "8": "Septembre",
                "9": "Octobre",
                "10": "Novembre",
                "1": "Février",
                "11": "Décembre",
                "7": "Août"
            },
            "weekdays": [
                "Dim",
                "Lun",
                "Mar",
                "Mer",
                "Jeu",
                "Ven",
                "Sam"
            ]
        },
        "editor": {
            "close": "Fermer",
            "create": {
                "title": "Créer une nouvelle entrée",
                "button": "Nouveau",
                "submit": "Créer"
            },
            "edit": {
                "button": "Editer",
                "title": "Editer Entrée",
                "submit": "Mettre à jour"
            },
            "remove": {
                "button": "Supprimer",
                "title": "Supprimer",
                "submit": "Supprimer",
                "confirm": {
                    "_": "Êtes-vous sûr de vouloir supprimer %d lignes ?",
                    "1": "Êtes-vous sûr de vouloir supprimer 1 ligne ?"
                }
            },
            "multi": {
                "title": "Valeurs multiples",
                "info": "Les éléments sélectionnés contiennent différentes valeurs pour cette entrée. Pour modifier et définir tous les éléments de cette entrée à la même valeur, cliquez ou tapez ici, sinon ils conserveront leurs valeurs individuelles.",
                "restore": "Annuler les modifications",
                "noMulti": "Ce champ peut être modifié individuellement, mais ne fait pas partie d'un groupe. "
            },
            "error": {
                "system": "Une erreur système s'est produite (<a target=\"\\\" rel=\"nofollow\" href=\"\\\">Plus d'information<\/a>)."
            }
        },
        "stateRestore": {
            "removeSubmit": "Supprimer",
            "creationModal": {
                "button": "Créer",
                "order": "Tri",
                "paging": "Pagination",
                "scroller": "Position du défilement",
                "search": "Recherche",
                "select": "Sélection",
                "columns": {
                    "search": "Recherche par colonne",
                    "visible": "Visibilité des colonnes"
                },
                "name": "Nom :",
                "searchBuilder": "Recherche avancée",
                "title": "Créer un nouvel état",
                "toggleLabel": "Inclus :"
            },
            "renameButton": "Renommer",
            "duplicateError": "Il existe déjà un état avec ce nom.",
            "emptyError": "Le nom ne peut pas être vide.",
            "emptyStates": "Aucun état sauvegardé",
            "removeConfirm": "Voulez vous vraiment supprimer %s ?",
            "removeError": "Échec de la suppression de l'état.",
            "removeJoiner": "et",
            "removeTitle": "Supprimer l'état",
            "renameLabel": "Nouveau nom pour %s :",
            "renameTitle": "Renommer l'état"
        },
        "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
        "infoEmpty": "Affichage de 0 à 0 sur 0 entrées",
        "infoFiltered": "(filtrées depuis un total de _MAX_ entrées)",
        "lengthMenu": "Afficher _MENU_ entrées",
        "paginate": {
            "first": "Première",
            "last": "Dernière",
            "next": "Suivante",
            "previous": "Précédente"
        },
        "zeroRecords": "Aucune entrée correspondante trouvée",
        "thousands": " "
    }
})

function initSW() {
    if (!"serviceWorker" in navigator) {
        //service worker isn't supported
        return;
    }

    //don't use it here if you use service worker
    //for other stuff.
    if (!"PushManager" in window) {
        //push isn't supported
        return;
    }

    //register the service worker
    navigator.serviceWorker.register(location.protocol + "//" + location.host+'/sw.js')
        .then(() => {
            initPush();
        })
        .catch((err) => {
            console.log(err)
        });
}

function initPush() {
    if (!navigator.serviceWorker.ready) {
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (result) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    })
        .then((permissionResult) => {
            if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
            }
            subscribeUser();
        });
}

function subscribeUser() {
    navigator.serviceWorker.ready
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                    'BHpvE3KwAjBm94K4LYXcjzRX4vzxBz2IP5KIYmd9WyfJ4WN3HR2wa95Fw7x0r0pn0P6K7qRt1cMSs_BPL_lA7Tk'
                )
            };

            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            storePushSubscription(pushSubscription);
        });
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');

    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);

    for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }

    return outputArray;
}

function storePushSubscription(pushSubscription) {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    fetch('/push', {
        method: 'POST',
        body: JSON.stringify(pushSubscription),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    })
        .then((res) => {
            return res.json();
        })
        .then(() => {
        })
        .catch((err) => {
            console.log(err)
        });
}

if(document.querySelector('.ckeditor')) {
    window.addEventListener('load', e => {
        let options = {
            selector: '.ckeditor',
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            link_list: [
                { title: 'My page 1', value: 'https://www.tiny.cloud' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_list: [
                { title: 'My page 1', value: 'https://www.tiny.cloud' },
                { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_class_list: [
                { title: 'None', value: '' },
                { title: 'Some class', value: 'class-name' }
            ],
            importcss_append: true,
            file_picker_callback: function (callback, value, meta) {
                /* Provide file and text for the link dialog */
                if (meta.filetype === 'file') {
                    callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
                }

                /* Provide image and alt text for the image dialog */
                if (meta.filetype === 'image') {
                    callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
                }

                /* Provide alternative source and posted for the media dialog */
                if (meta.filetype === 'media') {
                    callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
                }
            },
            templates: [
                { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
                { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
                { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
            ],
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image imagetools table',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        }

        tinymce.init(options)
    })
}

document.querySelectorAll('.datepick').forEach(dat => {
    $(dat).flatpickr({
        locale: 'fr'
    });
})

let selects = document.querySelectorAll('[data-control="select2"]')
let inputMasks = document.querySelectorAll('.maskinput')

selects.forEach(select => {
    if(select.dataset.uri) {
        console.log($(select))
        $(select).select2({
            ajax:{
                url: select.dataset.uri,
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    console.log(data)
                    return {
                        results: data
                    };
                },
                cache: true
            }
        })
    }
})

inputMasks.forEach(input => {
    Inputmask({
        "mask": input.dataset.mask
    }).mask(input)
})

let tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]')
tooltipElements.forEach(tooltip => {
    new bootstrap.Tooltip(tooltip, {html: true})
})

window.addEventListener('load', () => {
    if("serviceWorker" in navigator) {
        navigator.serviceWorker.register(location.protocol + "//" + location.host+'/sw_customer.js');
        initSW();
    }
})




