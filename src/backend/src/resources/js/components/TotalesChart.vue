<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  props: [
      'nuevos',
      'aceptados',
      'rechazados',
      'pendientes',
      'premiados',
      'options'],
  mounted () {
    this.renderChart({
			labels: [`Nuevos`, 'Aceptados', 'Rechazados', 'Pendientes','Premiados'],
			datasets: [{
				label: 'Tickets',
				backgroundColor: [
                    '#003f5c',
                    '#58508d',
                    '#bc5090',
                    '#ff6361'
                ],
				borderColor: '#ffffff',
				borderWidth: 1,
				data: [
					parseInt(this.nuevos),
					parseInt(this.aceptados),
					parseInt(this.rechazados),
					parseInt(this.pendientes),
					parseInt(this.premiados),
				]
			}]

		}, this.options)
  }
}
</script>

<style>
</style>