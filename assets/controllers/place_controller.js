// import { Controller } from '@hotwired/stimulus';
//
// export default class extends Controller {
//     static targets = ['input', 'suggestions']
//
//     connect() {
//         this.timeout = null;
//     }
//
//     onInput() {
//         clearTimeout(this.timeout);
//
//         this.timeout = setTimeout(() => {
//             this.fetchSuggestions();
//         }, 300);
//     }
//
//     async fetchSuggestions() {
//         const query = this.inputTarget.value;
//
//         if (query.length < 3) {
//             this.suggestionsTarget.innerHTML = '';
//             return;
//         }
//
//         const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=5&accept-language=fr`);
//         const data = await response.json();
//
//         this.suggestionsTarget.innerHTML = data.map(place => {
//             return `<a href="#" class="list-group-item list-group-item-action" data-action="click->place#selectSuggestion" data-lat="${place.lat}" data-lon="${place.lon}">${place.display_name}</a>`;
//         }).join('');
//     }
//
//     selectSuggestion(event) {
//         const suggestion = event.target;
//         this.inputTarget.value = suggestion.textContent;
//         this.suggestionsTarget.innerHTML = '';
//
//         // Vous pouvez également stocker les coordonnées ici si nécessaire
//         console.log('Selected place coordinates:', suggestion.dataset.lat, suggestion.dataset.lon);
//     }
// }

import { Controller } from '@hotwired/stimulus';
import TomSelect from 'tom-select';
import 'tom-select/dist/css/tom-select.min.css'

export default class extends Controller {
    static targets = ['input']

    connect() {
        this.initTomSelect();
    }

    initTomSelect() {
        new TomSelect(this.inputTarget, {
            maxItems: 1,
            create: false,
            load: (query, callback) => {
                if (!query.length) return callback();

                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=5`)
                    .then(response => response.json())
                    .then(data => {
                        const results = data.map(place => ({
                            value: `${place.lat},${place.lon}`,
                            text: place.display_name
                        }));
                        callback(results);
                    }).catch(() => {
                    callback();
                });
            },
            onItemAdd: (value, item) => {
                console.log('Selected place coordinates:', value); // lat,lon format
            }
        });
    }
}
