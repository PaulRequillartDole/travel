import { Controller } from '@hotwired/stimulus';
import 'tom-select/dist/css/tom-select.bootstrap4.min.css'
import TomSelect from "tom-select/dist/js/tom-select.complete.min";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        function bindSelect(select){
            new TomSelect(select, {
                plugins: ['dropdown_input', 'remove_button'],
            })
        }

        bindSelect(this.element);
    }
}
