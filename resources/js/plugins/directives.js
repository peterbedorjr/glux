import Vue from 'vue';
import marked from 'marked';

marked.setOptions({
    headerIds: false,
});

Vue.directive('markdown', {
    bind(el, { value }) {
        el.innerHTML = marked.parse(value);
    },
});
