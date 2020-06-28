require("./bootstrap");
import "places.js";

$(document).ready(function() {
    //SLIDER RADIUS//////////////
    var slider = document.getElementById("radius");
    var output = document.getElementById("radius-display-km");
    output.innerHTML = slider.value; // Display the default slider value

    // Update the current slider value (each time you drag the slider handle)
    slider.oninput = function() {
        output.innerHTML = this.value;
    };
    ////////////////////////////////
});
