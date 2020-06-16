require("./bootstrap");

import 'places.js';

// const algoliasearch = require("algoliasearch/lite");
// const instantsearch = require("instantsearch.js").default;

import algoliasearch from "algoliasearch/lite";
import instantsearch from "instantsearch.js";
import { searchBox, hits } from "instantsearch.js/es/widgets";
import { connectAutocomplete } from 'instantsearch.js/es/connectors';
import { connectSearchBox } from 'instantsearch.js/es/connectors';


$(document).ready(function() {
    const searchClient = algoliasearch(
        "XZ2HPLQIIE",
        "7958bcb2f0ac963e3263a68539176db6"
    );

    const search = instantsearch({
        indexName: "apartments",
        searchClient
    });

    // Create a render function
    const renderSearchBox = (renderOptions, isFirstRender) => {
      const { query, refine, clear, isSearchStalled, widgetParams } = renderOptions;

      if (isFirstRender) {
        const input = document.createElement('input');

        const loadingIndicator = document.createElement('span');
        loadingIndicator.textContent = 'Loading...';

        const button = document.createElement('button');
        button.textContent = 'X';

        input.addEventListener('input', event => {
          refine(event.target.value);
        });

        button.addEventListener('click', () => {
          clear();
        });

        widgetParams.container.appendChild(input);
        widgetParams.container.appendChild(loadingIndicator);
        widgetParams.container.appendChild(button);
      }

      widgetParams.container.querySelector('input').value = query;
      widgetParams.container.querySelector('span').hidden = !isSearchStalled;
    };

    // create custom widget
    const customSearchBox = connectAutocomplete(
      renderSearchBox
    );
    // const customSearchBox = instantsearch.connectors.connectSearchBox(
    //   renderSearchBox
    // );

    // instantiate custom widget
    search.addWidgets([
      customSearchBox({
        container: document.querySelector('#searchbox'),
      })
    ]);

    // search.addWidgets([
    //     searchBox({
    //         container: ".instantsearch"
    //     }),
    //
    //     hits({
    //         container: "#hits",
    //         // templates: {
    //         //     item(item) {
    //         //         return `👉 ${item.address}`;
    //         //     }
    //         // }
    //         templates: {
    //             item: `
    //
    //             <div>
    //               <h4>
    //               <a href="/user/apartments/{{id}}">
    //                 {{ title }}
    //                 </a>
    //               </h4>
    //               <p>{{ address }}</p>
    //               <img src="{{ img_path }}" alt="" width=100px>
    //              </div>
    //
    //             `
    //         }
    //     })
    // ]);

    search.start();
});
