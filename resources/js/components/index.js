// TODO: Reduce number of global components

import Vue from 'vue';
import { HasError, AlertError, AlertSuccess } from 'vform';
import Card from './Card';
import Child from './Child';
import Button from './Button';

// Components that are registered globaly.
[
    Card,
    Child,
    Button,
    HasError,
    AlertError,
    AlertSuccess,
].forEach((Component) => {
    Vue.component(Component.name, Component);
});
