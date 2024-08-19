import { Controller } from '@hotwired/stimulus';

import 'prismjs/themes/prism.min.css';
import '@toast-ui/editor-plugin-code-syntax-highlight/dist/toastui-editor-plugin-code-syntax-highlight.css';

import Prism from 'prismjs';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-js-extras'
import 'prismjs/components/prism-cshtml'
import 'prismjs/components/prism-markup-templating';

import Editor from '@toast-ui/editor/dist/toastui-editor-viewer';
import '@toast-ui/editor/dist/theme/toastui-editor-dark.css'
import '@toast-ui/editor/dist/toastui-editor-viewer.css'
import codeSyntaxHighlight  from '@toast-ui/editor-plugin-code-syntax-highlight';

export default class extends Controller {
    connect() {
        const editor = new Editor({
            el: this.element,
            initialValue: this.element.dataset.value,
            // plugins: [[codeSyntaxHighlight, { highlighter: Prism }]],
            events: {
                change: ev => {
                    console.log('change');
                    console.log(editor.getMarkdown());
                }
            }
        });

        let tasks = this.element.querySelectorAll(".task-list-item");
        tasks.forEach(task => {
            task.addEventListener('click', function (e){
                console.log("checked / unchecked");
            })
        });
    }
}
