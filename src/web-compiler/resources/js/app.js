/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

$ = require('jquery');
require('./wScratchPad');
// console.log($.fn.wScratchPad);
import Vue from 'vue'
import Vue2TouchEvents from 'vue2-touch-events'

Vue.use(Vue2TouchEvents);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('formulario-ticket', require('./components/FormularioTicket.vue').default);
Vue.component('registros', require('./components/RegisterCounter.vue').default);
Vue.component('rasca', require('./components/Rasca.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

(function ($) {
  const f = $("#xCampaignForm").get(0);
  const xF = $.parseHTML('<formulario-ticket ></formulario-ticket>');
  $(xF).insertBefore(f);
  $(xF).append(f);
})($);

const app = new Vue({
  el: '.xPageInner',
  data() {
    return {
    }
  },
  methods: {

  },
  mounted() {

  }
});


