import { Controller } from '@hotwired/stimulus';
import flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.css'
import fr from 'flatpickr/dist/l10n/fr'
flatpickr.localize(fr);

export default class extends Controller {
    static targets = [ "datepicker", "start", "end" ];

    connect() {
        let start = this.startTarget;
        let end = this.endTarget;
        flatpickr(this.datepickerTarget, {
            mode: "range",
            dateFormat: "Y-m-d",
            locale: fr,
            onChange: function(selectedDates, dateStr, instance) {
                console.log(selectedDates[0], selectedDates[1] ? selectedDates[1].toLocaleDateString(): null);
                start.value = getFormatedDate(selectedDates[0]);
                end.value = selectedDates[1] ? getFormatedDate(selectedDates[1]) : null;
                console.log(start.value, end.value)
            },
        });
    }

}

function getFormatedDate(date){
    // return date.getFullYear() + "-" + (parseInt(date.getMonth())+1) + "-" + date.getDate();
    return date.toLocaleDateString();
}
