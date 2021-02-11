// URL vers l'API
const API = "http://localhost:8000";

// Récuperer le paramètre de l'URL
let url = new URL(window.location.href);
let id = url.searchParams.get('id');

// Element HTML "body"
let body = document.querySelector("body");

// Instanciation du convertisseur MarkDown -> HTML
let converter = new showdown.Converter();
let timer = 0;
let index = 0;

if(id == null || id == "") {
    body.innerHTML = "Pas de séquence sélectionnée.";
} else {
    // Récupération des écrans appartenant à une séquence donnée
    fetch(API + "/ecrans/" + id)
    .then(response => response.json())
    .then(function (screens) {
        // Si la séquence ne contient pas d'écran(s)
        if(screens.length < 1) {
            document.location.href = '/';
        } else {
            wait(screens[index].contenu, screens[index].temps, screens);
        }
    });
}

// Fonction permettant d'attendres X secondes avant de passer à l'écran suivant
function wait(contenu, temps, screens) {
    body.innerHTML = converter.makeHtml(contenu);
    setTimeout(function() {
        if(screens[index + 1]) {
          index++;
        } else {
          index = 0;
          refresh();
        }
        wait(screens[index].contenu, screens[index].temps, screens);
    }, temps);
}

// Rafraichissement de la page
function refresh() {
    window.location.reload();
}