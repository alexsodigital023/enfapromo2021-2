<template>
  <div class="container rascar">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div
          v-for="(medalla, index) in medallas"
          :key="index"
          ref="rasca_ref"
          name="rasca"
          :class="`scratchpad scratchpad_${index}`"
          @mousedown="select(index)"
        ></div>
        <!-- @mousedown="consumeTry2" -->
        <!-- <div id="23" class="scratchpad"></div> -->
      </div>
    </div>
  </div>
</template> 

<script >
export default {
  props: {
    medallas: null,
    oportunidades: null,
    ganador: null,
    p_max: null,
  },
  data() {
    return {
      intentos: null,
      scratch: {
        porcentaje: 0,
        ganador: false,
      },
    };
  },

  watch: {
    intentos() {
      console.log('watch  ' + this.intentos);
      if (this.intentos >= 1) {
      } else {
        // console.log('No mas Intentos');
      }
    },
  },
  mounted() {
    // console.log(this);
    // console.log(this.$refs.rasca_ref);
    // console.log(this.p_max);
    this.intentos = this.oportunidades;
    this.setConfig(this, this.p_max);
    this.getRandomArray();
  },

  methods: {
    setConfig(refs, p_max) {
      $(this.$refs.rasca_ref).wScratchPad({
        size: 15, // The size of the brush/scratch.
        bg: 'images/lose.png', // Background (image path or hex color).
        fg: 'images/base.png', // Foreground (image path or hex color).
        // realtime: true, // Calculates percentage in realitime.
        // scratchDown: false, // Set scratchDown callback.
        // scratchUp: false, // Set scratchUp callback.
        // scratchMove: false, // Set scratcMove callback.
        // cursor      : 'crosshair' // Set cursor.
        cursor: 'url("images/cursors/mario.png") 5 5, default', // Set cursor.
        scratchDown: function (e, percent) {
          console.log('scratchDown');
          if (percent >= p_max && percent < 100) {
            console.log(percent);
            this.clear();
            refs.disableScratch(refs.$refs.rasca_ref.indexOf(this.$el[0]));
            refs.consumeTry();
          }
          if (percent == 100) {
            refs.disableScratch(refs.$refs.rasca_ref.indexOf(this.$el[0]));
            // console.log('100%');
          }
        },
        scratchUp: function (e, percent) {
          console.log('scratchUp');
          if (percent >= p_max && percent < 100) {
            // console.log(percent);
            this.clear();
            refs.disableScratch(refs.$refs.rasca_ref.indexOf(this.$el[0]));
            refs.consumeTry();
          }
          if (percent == 100) {
            refs.disableScratch(refs.$refs.rasca_ref.indexOf(this.$el[0]));
            // console.log('100%');
          }
        },
        scratchMove: function (e, percent) {
          console.log('scratchMove');

          if (percent >= p_max && percent < 100) {
            // console.log(percent);
            // console.log(this.$el[0]);
            // console.log(refs.$refs.rasca_ref);
            // console.log(refs.$refs.rasca_ref.indexOf(this.$el[0]));
            // console.log(refs_rasca_ref.indexOf(this.$el[0]));
            this.clear();
            refs.disableScratch(refs.$refs.rasca_ref.indexOf(this.$el[0]));
            /* refs.consumeTry3(
              refs.$refs.rasca_ref.indexOf(this.$el[0]),
              percent
            ); */
            refs.consumeTry();
          }
          if (percent == 100) {
            refs.disableScratch(refs.$refs.rasca_ref.indexOf(this.$el[0]));
            // console.log('100%');
          }
        },
      });
    },

    consumeTry() {
      this.intentos--;
      // console.log(this.intentos);
    },
    consumeTry2() {
      if (this.intentos >= 1) {
        this.intentos--;
        console.log(this.intentos);
      } else {
        console.log('Ya no Tienes intentos');
      }
    },
    consumeTry3(index, percent) {
      this.$refs.rasca_ref[index].percent = percent;
      // console.log(this.$refs.rasca_ref[index]);
      // console.log(this.$refs.rasca_ref[index].percent);
      if (this.$refs.rasca_ref[index].percent < this.p_max) {
      }
      if (this.$refs.rasca_ref[index].percent >= this.p_max) {
      }
      if (this.$refs.rasca_ref[index].percent > 1) {
        this.intentos--;
      }
      // this.intentos--;
      // console.log(this.intentos);
    },
    intentoScratch(oportunidades) {
      if (this.intentos >= 1) {
        console.log('Aun tienes intentos');
      } else {
        console.log('Ya no Tienes intentos');
      }
    },
    enableScratch() {
      $(this.$refs.rasca_ref).wScratchPad('enable', true);
      // $('.enable').wScratchPad('enable', true);
    },
    disableScratch(index) {
      $(this.$refs.rasca_ref[index]).wScratchPad('enable', false);
      // console.log(index);
      // $('.disable').wScratchPad('enabled', false);
    },
    selected(index) {},
    select(index) {
      // $(this.$refs.rasca_ref[index]).addClass('enable').removeClass('disable').wScratchPad('enable', true);
      // $(this.$refs.rasca_ref[index]).addClass('enable').removeClass('disable')
      // $(this.$refs.rasca_ref[index]).addClass('disable').removeClass('enable')
      // $(this.$refs.rasca_ref).wScratchPad('enable', false);
      /* if (this.intentos >= 1) {
        $(this.$refs.rasca_ref[index]).wScratchPad('enable', true);

        // console.log(this.intentos);
      } */
    },
    getRandomArray() {
      let cantidadNumeros = this.medallas;
      let myArray = [];
      while (myArray.length < cantidadNumeros) {
        let numeroAleatorio = Math.floor(Math.random() * cantidadNumeros);
        // console.log('Numero Aleatorio = ' + numeroAleatorio);
        if (!myArray.includes(numeroAleatorio)) {
          myArray[myArray.length] = numeroAleatorio;
          if (numeroAleatorio == this.ganador) {
            this.setWinner(myArray.indexOf(this.ganador));
            // break;
          }
        }
      }
      console.log(myArray);
    },
    setWinner(ganador) {
      $(this.$refs.rasca_ref[ganador]).wScratchPad('bg', 'images/win.jpg');
      // console.log(typeof this.$refs.rasca_ref[ganador]);
      // console.log(this.$refs.rasca_ref[ganador]);
      // console.log(Object.values(this.$refs.rasca_ref[ganador]));
    },
  },
};
</script>
<style scoped>
.scratchpad {
  width: 100px;
  height: 100px;
  border: solid 1px;
  display: inline-block;
}
/* .enable {
} */
</style>


