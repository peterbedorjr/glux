import Vue from 'vue';
import marked from 'marked';
import hljs from './hljs';

marked.setOptions({
    headerIds: false,
    highlight(code, lang) {
        if (lang) {
            return hljs.highlight(lang, code).value;
        }

        return code;
    },
});

Vue.directive('markdown', {
    bind(el, { value }) {
        el.innerHTML = marked.parse(value);
    },
});
