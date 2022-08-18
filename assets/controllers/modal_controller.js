import { Controller } from '@hotwired/stimulus';
import Modal from "bootstrap/js/dist/modal";

export default class extends Controller {
    static targets = [ 'modal', 'table', 'row'];

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
                content.innerHTML = html;
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
                            const tbody = this.tableTarget.querySelector('tbody');
                            //append tr to the tbody
                            tbody.insertAdjacentHTML('beforeend', data.row);
                        }else if(data.type === "edit"){
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
                    }else{
                        this.modalTarget.querySelector('.modal-content').innerHTML = "<div class='alert alert-danger'>" + data + "</div>";
                    }
                }else{
                    this.modalTarget.querySelector('.modal-content').innerHTML = data;
                }
            })
    }
}