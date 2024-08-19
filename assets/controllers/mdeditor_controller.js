import { Controller } from '@hotwired/stimulus';
import 'prismjs/themes/prism.min.css';
import '@toast-ui/editor-plugin-code-syntax-highlight/dist/toastui-editor-plugin-code-syntax-highlight.css';

import Prism from 'prismjs';
import 'prismjs/components/prism-php';
import 'prismjs/components/prism-js-extras'
import 'prismjs/components/prism-cshtml'
import 'prismjs/components/prism-markup-templating';

import Editor from '@toast-ui/editor';
import '@toast-ui/editor/dist/toastui-editor.css';
import '@toast-ui/editor/dist/theme/toastui-editor-dark.css'
import '@toast-ui/editor/dist/i18n/fr-fr';
import codeSyntaxHighlight  from '@toast-ui/editor-plugin-code-syntax-highlight';

export default class extends Controller {
    static targets = ["textarea", "editor"];


    connect() {
        const editorTarget = this.editorTarget;
        const editor = new Editor({
            el: editorTarget,
            initialValue: editorTarget.dataset.value,
            initialEditType: 'wysiwyg',
            plugins: [[codeSyntaxHighlight, { highlighter: Prism }]],
            language: 'fr-FR',
            height: 'auto',
        });

        editor.on('change', () => {
            this.textareaTarget.value = editor.getMarkdown();
        });
    }
}
