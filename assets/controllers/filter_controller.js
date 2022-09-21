import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ 'form', 'voyage'];

    connect() {
        const voyagesElements = this.voyageTargets;
        // voyagesElements = Array.from(voyagesElements);

    }

    test(event){
        console.log(event.target);
        Array.from(this.voyageTargets).forEach(voyage => {
            if (voyage.dataset.status == 0){
                voyage.parentNode.classList.add('d-block')
            }
        })
    }
}
