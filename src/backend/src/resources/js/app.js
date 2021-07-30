/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
require('./sb-admin-2');

window.Vue = require('vue');

import { ToggleButton } from 'vue-js-toggle-button'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('ver-ticket', require('./components/VerTicket.vue').default);
Vue.component('ver-foto', require('./components/VerFoto.vue').default);
Vue.component('aprobar-ticket', require('./components/AprobarTicket.vue').default);
Vue.component('rechazar-ticket', require('./components/RechazarTicket.vue').default);
Vue.component('premiar-ticket', require('./components/PremiarTicket.vue').default);
Vue.component('despremiar-ticket', require('./components/DesPremiarTicket.vue').default);
Vue.component('ticket', require('./components/Ticket.vue').default);
Vue.component('tickets', require('./components/Tickets.vue').default);
Vue.component('status-selector', require('./components/StatusSelector.vue').default);
Vue.component('semana-selector', require('./components/SemanaSelector.vue').default);
Vue.component('profile-selector', require('./components/ProfileSelector.vue').default);
Vue.component('search-box', require('./components/SearchBox.vue').default);
Vue.component('users', require('./components/Users.vue').default);
Vue.component('participantes', require('./components/Participantes.vue').default);
Vue.component('ToggleButton', ToggleButton);
Vue.component('totales-chart', require('./components/TotalesChart.vue').default);
Vue.component('recepciones-chart', require('./components/RecepcionesChart.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data(){
        return {
            invalidos:false
        };
    }
});
