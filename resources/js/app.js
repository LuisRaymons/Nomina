
require('./bootstrap');
window.Vue = require('vue').default;
import vuetify from './vuetify';
Vue.component('table-employees', require('./components/TableEmpleados.vue').default);
const app = new Vue({
    el: '#app',
    vuetify
});


/*
require('./bootstrap');
window.Vue = require('vue');
import vuetify from './vuetify';
Vue.component('table-employees', require('./components/TableEmpleados.vue').default);

const app = new Vue({
    el: '#app',
    vuetify
});
*/