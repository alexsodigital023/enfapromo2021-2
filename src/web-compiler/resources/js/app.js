import $ from "jquery";
import Vue from 'vue';
import Vue2TouchEvents from 'vue2-touch-events';
import vClickOutside from 'v-click-outside';
import 'bootstrap';

Vue.use(vClickOutside);
Vue.use(Vue2TouchEvents);

Vue.component('formulario', require('./components/FormularioTicket.vue').default);
Vue.component('registros', require('./components/RegisterCounter.vue').default);
Vue.component('top-menu',require('./components/TopMenu').default);
Vue.component('end-register',require('./components/EndRegister').default);

$(document).ready(() => {
  $(".captcha-btn").on( "click", function() {
    $(".enfa-container").append("<div class='popEnfa'><form><div class='close'><span>x</span></div><div class='form-group'><label for='inputLetras'>¿Cuántas letras tiene <strong>Enfagrow</strong>?</label><input type='number' class='form-control' id='inputLetras'></div><button class='btn btn-primary btn-popEnfa'>Enviar</button></form></div>");

    $(".popEnfa").find(".close").click(()=>{
      $(".popEnfa").hide();
    });
  });
});

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





