import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [ 'form', 'voyage', 'filter'];

    connect() {
        const voyagesElements = this.voyageTargets;
        // voyagesElements = Array.from(voyagesElements);
        this.applyFilter();
        this.checkFilter();
    }

    applyFilter(event){
        var filter = parseInt(event !== undefined ? event.target.value : this.getFilter());
        Array.from(this.voyageTargets).forEach(voyage => {
            var status = parseInt(voyage.dataset.status);
            if (status === filter || filter ===  0){
                voyage.parentNode.classList.remove('d-none')
                voyage.parentNode.classList.add('d-block')
            }else{
                voyage.parentNode.classList.remove('d-block')
                voyage.parentNode.classList.add('d-none')
            }
        })
        this.saveFilter(filter);
    }

    saveFilter(filter){
        localStorage.setItem('filter', filter);
    }

    getFilter(){
        return localStorage.getItem('filter') ?? 0;
    }

    checkFilter() {
        document.querySelector("input#filter_"+this.getFilter()).checked = true;
    }
}
