import Vue from 'vue';
import { HasError, AlertError, AlertSuccess } from 'vform';
import Card from './Card';
import Child from './Child';
import Button from './Button';
import Checkbox from './Checkbox';

// Components that are registered globaly.
[
    Card,
    Child,
    Button,
    Checkbox,
    HasError,
    AlertError,
    AlertSuccess,
].forEach((Component) => {
    Vue.component(Component.name, Component);
});
