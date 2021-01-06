const API = "http://localhost:8000";
let body = document.querySelector("body");
let converter = new showdown.Converter();

fetch(API + "/ecrans/1")
.then(response => response.json())
.then(function (screens) {
    screens.forEach((screen, index) => {
        if(index == 0) {
            body.innerHTML = converter.makeHtml(screen.contenu);
        } else {
            wait(body, screen.contenu, screen.temps, index);
        }
    });
});

function wait(element, contenu, temps, index) {
    setInterval(() => {
        element.innerHTML = converter.makeHtml(contenu);
    }, temps * index);  
}