require("./bootstrap");
import "places.js";

// const algoliasearch = require("algoliasearch/lite");
// const instantsearch = require("instantsearch.js").default;

import algoliasearch from "algoliasearch/lite";
import instantsearch from "instantsearch.js";
import { searchBox, hits } from "instantsearch.js/es/widgets";
import { connectAutocomplete } from "instantsearch.js/es/connectors";
import { connectSearchBox } from "instantsearch.js/es/connectors";

$(document).ready(function() {
    const searchClient = algoliasearch(
        "F3UGQY8R3Q",
        "361561dc5b21da9217e367f936aaa509"
    );

    const search = instantsearch({
        indexName: "apartments",
        searchClient
    });
    //===========================================

    var getParams = function(url) {
        var params = {};
        var parser = document.createElement("a");
        parser.href = url;
        var query = parser.search.substring(1);
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            params[pair[0]] = decodeURIComponent(pair[1]);
        }
        return params;
    };

    var myparams = getParams(window.location.href);

    console.log(myparams);

    var lat = myparams.lat;
    var lng = myparams.lng;
    var address = myparams.address;
    //============================================

    // // Create a render function

    // const renderSearchBox = (renderOptions, isFirstRender) => {
    //     const {
    //         query,
    //         refine,
    //         clear,
    //         isSearchStalled,
    //         widgetParams
    //     } = renderOptions;

    //     if (isFirstRender) {
    //         const input = document.createElement("input");

    //         const loadingIndicator = document.createElement("span");
    //         loadingIndicator.textContent = "Loading...";

    //         const button = document.createElement("button");
    //         button.textContent = "X";

    //         input.addEventListener("input", event => {
    //             refine(event.target.value);
    //         });

    //         button.addEventListener("click", () => {
    //             clear();
    //         });

    //         //widgetParams.container.appendChild(input);
    //         widgetParams.container.appendChild(loadingIndicator);
    //         widgetParams.container.appendChild(button);
    //     }

    //     widgetParams.container.querySelector("#lat").value = lat;
    //     widgetParams.container.querySelector("#lng").value = lng;
    //     widgetParams.container.querySelector("#address").value = address;
    //     //widgetParams.container.querySelector("span").hidden = !isSearchStalled;
    // };

    // create custom widget
    // const customSearchBox = connectAutocomplete(renderSearchBox);
    // const customSearchBox = instantsearch.connectors.connectSearchBox(
    //   renderSearchBox
    // );

    // instantiate custom widget
    // search.addWidgets([
    //     customSearchBox({
    //         container: document.getElementById("instantsearch")
    //     }),
    //     hits({
    //         container: "#hits",
    // templates: {
    //     item(item) {
    //         return `👉 ${item.address}`;
    //     }
    // }
    //         templates: {
    //             item: `

    //                     <div>
    //                       <h4>
    //                       <a href="/user/apartments/{{id}}">
    //                         {{ title }}
    //                         </a>
    //                       </h4>
    //                       <p>{{ address }}</p>
    //                       <img src="{{ img_path }}" alt="" width=100px>
    //                      </div>

    //                     `
    //         }
    //     })
    // ]);

    search.addWidgets([
        searchBox({
            container: "#instantsearch",
            queryHook(query, search) {
                search(query);
                console.log(query);
            }
        }),

        hits({
            container: "#hits",
            // templates: {
            //     item(item) {
            //         return `👉 ${item.address}`;
            //     }
            // }
            templates: {
                item: `
    
                <div>
                  <h4>
                  <a href="/user/apartments/{{id}}">
                    {{ title }}
                    </a>
                  </h4>
                  <p>{{ address }}</p>
                  <img src="{{ img_path }}" alt="" width=100px>
                 </div>
    
                `
            }
        })
    ]);

    search.start();
    // $(".ais-SearchBox-input").val(address);
});
