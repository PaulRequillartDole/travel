import { Controller } from '@hotwired/stimulus';
import 'emoji-picker-element'

export default class extends Controller {

    connect() {
        document.querySelector('emoji-picker')
            .addEventListener('emoji-click', event => console.log(event.detail));

    }
}
