<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: [
      'registros',
      'validos',
      'nuevos',
      'aceptados',
      'rechazados',
      'pendientes',
      'premiados',
      'options'],
  mounted () {
    const registros=JSON.parse(this.registros);
    const validos=JSON.parse(this.validos);
    const labels=[];
    const data = [];
    const labels2=[];
    const data2 = [];
    for(let i in registros){
      labels.push(registros[i].dia);
      data.push(registros[i].total);
    }
    for(let i in validos){
      labels2.push(validos[i].dia);
      data2.push(validos[i].total);
    }
    this.renderChart({
			labels: labels,
			datasets: [{
				label: 'Todos',
				backgroundColor: [
                    '#ff6361'
                ],
				borderColor: '#ffffff',
				borderWidth: 1,
				data: data
			},{
				label: 'Válidos',
				backgroundColor: [
                    '#003f5c'
                ],
				borderColor: '#ffffff',
				borderWidth: 1,
				data: data2
			}]

		}, this.options)
  }
}
</script>

<style>
</style>