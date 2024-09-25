import { Controller } from '@hotwired/stimulus';
import 'emoji-picker-element'

export default class extends Controller {
    static targets = ['icon']
    connect() {
        const icons = this.iconTargets;
        icons.forEach(input => {
            // Ajouter un écouteur d'événement pour le changement de sélection
            input.addEventListener('change', function() {
                // Retirer la classe 'selected-label' de tous les labels
                icons.forEach(choice => {
                    const label = document.querySelector(`span[data-value="${choice.id}"]`);
                    label.classList.remove('selected-label');
                });

                // Ajouter la classe 'selected-label' au label correspondant
                const selectedLabel = document.querySelector(`span[data-value="${input.id}"]`);
                selectedLabel.classList.add('selected-label');
            });
        });

        document.querySelector("#section_icon_placeholder").addEventListener('change', function (){
            icons.forEach(choice => {
                const label = document.querySelector(`span[data-value="${choice.id}"]`);
                label.classList.remove('selected-label');
            });
        })
    }
}
