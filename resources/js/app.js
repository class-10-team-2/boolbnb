require("./bootstrap");

$(document).ready(function() {
    var places = require("places.js");

    var placesAutocomplete = places({
        appId: "plK18ES1VVUV",
        apiKey: "a35efa1809de4a5d0825dd615e7359b3",
        container: document.querySelector(".address-input"),
        templates: {
            suggestion: function(suggestion) {
                return suggestion.value;
            }
        }
    }).configure({
        getRankingInfo: true
    });

    placesAutocomplete.on("change", function resultSelected(e) {
        document.querySelector(".lat-input").value =
            e.suggestion.latlng.lat || "";
        document.querySelector(".lng-input").value =
            e.suggestion.latlng.lng || "";
    });

    // alert('ciao')

    // var inputRadius = $('#address-input').value();
    //
    // const fixedOptions = {
    //   appId: 'YOUR_PLACES_APP_ID',
    //   apiKey: 'YOUR_PLACES_API_KEY',
    //   container: $('#search-input-id'),
    //   language: 'it', // Receives results in Italian
    //   countries: ['it'], // Search in Italy
    //   getRankingInfo=true
    // };
    //
    // const reconfigurableOptions = {
    //   type: 'address', // Search only for address
    //   aroundLatLngViaIP: false // disable the extra search/boost around the source IP
    // };
    //
    // const placesInstance = places(fixedOptions).configure(reconfigurableOptions);
    //
    // // riconfigurazione delle opzioni
    // // raggio di ricerca dinamico a partire dalle coordinate dell'indirizzo selezionato
    // placesInstance.configure({
    //   aroundRadius: inputRadius
    // })
});
