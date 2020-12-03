<template>
    <table class="table table-tickets">
        <thead>
            <tr>
                <th>Ticker</th>
                <th>Folio</th>
                <th>Fecha de Registro</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="t in tickets" :key="t.numTicket">
                <td>{{t.numTicket}}</td>
                <td>{{t.folio}}</td>
                <td>{{t.fecha.getDate()}} {{meses[t.fecha.getMonth()]}} {{t.fecha.getFullYear()}}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        data(){
            return {
                tickets:[],
                meses:[
                    'ENE',
                    'FEB',
                    'MAR',
                    'ABR',
                    'MAY',
                    'JUN',
                    'JUL',
                    'AGO',
                    'SEP',
                    'OCT',
                    'NOV',
                    'DIC',
                ]
            }
        },
        mounted() {
            for(let i=0;i<10;i++){
                this.tickets.push({
                    numTicket:Math.round(Math.random()*1000000000),
                    folio: Math.round(Math.random()*1000000000),
                    fecha: new Date()
                });
            }
        }
    }
</script>
