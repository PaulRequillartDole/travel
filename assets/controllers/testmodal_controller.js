import { Controller } from '@hotwired/stimulus';
import Modal from "bootstrap/js/dist/modal";

export default class extends Controller {
    static targets = [ 'modal', 'table', 'row', 'container'];

    connect() {
        this.modal = new Modal(this.modalTarget)
        this.modalTarget.addEventListener('hidden.bs.modal', () => {
            this.modalTarget.querySelector('.modal-content').innerHTML = '';
        });
    }

    showModal(event){
        event.preventDefault();
        const params = event.params;
        const url = params.url;
        const size = params.size;
        console.log(size);
        //fetch the modal content from the server
        fetch(url, {
            headers: {
                //XMLHttpRequest
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                const content = this.modal._element.querySelector('.modal-content');
                const dialog = this.modal._element.querySelector('.modal-dialog');
                content.innerHTML = html;
                if (size !== undefined){
                    dialog.className = "modal-dialog " + size;
                }else{
                    dialog.className = "modal-dialog modal-fullscreen-md-down";
                }
                this.modal.show();
            });
    }

    submitForm(event){
        event.preventDefault();
        const form = this.modalTarget.querySelector('form');
        const formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            body: new URLSearchParams(formData)
        })
            //pas utilisé dans ce projet
            .then(r => {
                //if json return, then parse it
                if(r.headers.get('Content-Type').includes('json')){
                    return r.json();
                }else{
                    return r.text();
                }
            })
            .then(data => {
                //if json, check if success
                if(typeof data === 'object'){
                    if (data.status === 'success') {
                        if (data.type === "new"){
                            this.containerTarget.insertAdjacentHTML('beforeend', data.row);
                        }else if(data.type === "edit"){
                            console.log(data.row.id)
                            const row = this.tableTarget.querySelector(`tr[data-id="${data.id}"]`);
                            //replace the row with the new one
                            row.outerHTML = data.row;
                        }else if(data.type === "delete"){
                            const row = this.tableTarget.querySelector(`tr[data-id="${data.id}"]`);
                            //remove the row
                            row.remove();
                        }
                        this.modal.hide();
                        this.modalTarget.querySelector('.modal-content').innerHTML = '';
                        this.reloadFilter();
                    }else{
                        this.modalTarget.querySelector('.modal-content').innerHTML = "<div class='alert alert-danger'>" + data + "</div>";
                    }
                }else{
                    this.modalTarget.querySelector('.modal-content').innerHTML = data;
                }
            })
    }

    reloadFilter() {
        console.log(this.filterController);
        this.filterController.applyFilter();
    }

    get filterController() {
        return this.application.getControllerForElementAndIdentifier(document.querySelector("div[data-controller='filter']"), "filter")
    }
}