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
            // screens.forEach(function(screen, index) {
            //     console.log(screen.temps);
            //     timer += screen.temps;
            //     wait(body, screen.contenu, screen.temps, index);
            // });
            // refresh(timer);

            wait(body, screens[index].contenu, screens[index].temps, index, screens);
        }
    });
}

// Fonction permettant d'attendres X secondes avant de passer à l'écran suivant
function wait(element, contenu, temps, index, test) {
    // setTimeout(function() {
    //     element.innerHTML = converter.makeHtml(contenu);
    // }, temps * index);
    setTimeout(function() {
        element.innerHTML = converter.makeHtml(contenu);
        index++;
        wait(body, test[index].contenu, test[index].temps, index, test);
    }, temps);
}

// Refresh de la page à la fin du timer donné
function refresh(timer) {
    setTimeout(function() {
        window.location.reload();
    }, timer);
}