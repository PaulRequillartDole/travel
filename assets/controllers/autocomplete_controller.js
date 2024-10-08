import { Controller } from '@hotwired/stimulus';
import TomSelect from "../vendor/tom-select/tom-select.index.js";

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
