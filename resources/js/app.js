require("./bootstrap");

// const algoliasearch = require("algoliasearch/lite");
// const instantsearch = require("instantsearch.js").default;

import algoliasearch from "algoliasearch/lite";
import instantsearch from "instantsearch.js";
import { searchBox, hits } from "instantsearch.js/es/widgets";

$(document).ready(function() {
    const searchClient = algoliasearch(
        "F3UGQY8R3Q",
        "361561dc5b21da9217e367f936aaa509"
    );

    const search = instantsearch({
        indexName: "apartments",
        searchClient
    });

    search.addWidgets([
        searchBox({
            container: ".instantsearch"
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
                <a href="{{route('user.apartments.show', {{id}} )}}">
                <div>
                  <h4>
                    {{ title }}
                  </h4>
                  <p>{{ address }}</p>
                  <img src="{{ img_path }}" alt="" width=100px>
                 </div>
                  </a>
                `
            }
        })
    ]);

    search.start();
});
