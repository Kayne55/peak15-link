import App from './modules/app.js';

const app = new App();

window.addEventListener("load", function() {
    var tabs = document.querySelectorAll("ul.nav-tabs > li");

    var i;

    for (i = 0; i < tabs.length; i++) {
        tabs[i].addEventListener("click", switchtab);
    }

    function switchtab(event) {
        event.preventDefault();

        document.querySelector("ul.nav-tabs li.active").classList.remove("active");
        document.querySelector(".tab-pane.active").classList.remove("active");

        var clickedTab = event.currentTarget;
        var anchor = event.target;
        var activePaneID = anchor.getAttribute("href");


        clickedTab.classList.add("active");
        document.querySelector(activePaneID).classList.add("active");

    }
});