if(process.env.NODE_ENV=='development'){
  $ = require('jquery');
}

import Vue from 'vue'
import Vue2TouchEvents from 'vue2-touch-events'
import vClickOutside from 'v-click-outside';  
     
Vue.use(vClickOutside);  
Vue.use(Vue2TouchEvents);

Vue.component('formulario', require('./components/FormularioTicket.vue').default);
Vue.component('registros', require('./components/RegisterCounter.vue').default);
Vue.component('rasca', require('./components/Rasca.vue').default);
Vue.component('top-menu',require('./components/TopMenu').default);

$(document).ready(()=>{
  (function ($) {
    const f = $("#xCampaignForm").get(0);
    const xF = $.parseHTML('<formulario ></formulario>');
    $(xF).insertBefore(f);
    $(xF).append(f);
  
    const f1 = $("#xSectionHeader").get(0);
    const xF1 = $.parseHTML('<top-menu ></top-menu>');
    $(xF1).insertBefore(f1);
    $(xF1).append(f1);
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
});


