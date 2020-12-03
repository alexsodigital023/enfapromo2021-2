<template>
    <div class="topSemanal">
        <h1>Top semanal {{semanas[semanaActual]}}</h1>
        <div class="row row-ganadores">
            <div class="row-ganadores-inner">
                <div v-for="(g,i) in ganadoresTop" v-bind:key="i" :class="`col col-ganador image-container prioridad_${g.prioridad}`">
                    <div class="cover"></div>
                    <img v-if="g.foto" :src="g.foto" alt="Foto de ganador">
                    <div class="text-center">
                        <div><b>{{g.nombre}} {{g.apellido}}</b></div>
                        <div>{{g.estado}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lista marco8">
            <div class="marco-content">
                <select v-model="semanaActual">
                    <option v-for="(n,i) in semanas" :key="`opt_${i}`" :value="i">{{n}}</option>
                </select>
                <ul>
                    <li v-for="(g,i) in ganadores" v-bind:key="i" :class="`ganador-item`">
                        <span>{{g.nombre}} {{g.apellido}}</span>
                        <span>{{g.email}}</span>
                        <span>{{g.estado}}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

import https from 'https';

    export default {
        mounted() {
            this.fecha=new Date();
        },
        data(){
            return {
                showLista:false,
                fecha:new Date(),
                semanas:{
                    36:'sep 4 - 10',
                    37:'sep 11 - 17',
                    38:'sep 18 - 24',
                    39:'sep 25 - oct 1',
                    40:'oct 2 - oct 8',
                    41:'oct 9 - 15',
                    42:'oct 16 - 22',
                    43:'oct 23 - 30',
                },
                inicioSemana:null,
                finSemana:null,
                semanaActual:36,
                mes:null,
                blackIdx:0,
                back:false,
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
                ],
                ganadoresRaw:[],
                ganadores:[],
                ganadoresTop:[
                ]
            };
        },
        watch:{
            ganadoresRaw(){
                this.ganadores=this.ganadoresRaw;
                if(!this.ganadoresTop.length){
                    this.ganadoresTop=this.ganadores.slice(0,3);
                }
            },
            fecha(){
                this.inicioSemana=this.findInicioSemana();
                this.finSemana=this.findFinSemana();
                this.mes=this.meses[this.fecha.getMonth()];
                this.semanaActual=this.findWeek();
            },
            semanaActual(){
                this.loadGanadores();
            }
        },
        methods:{
            isBlack(){
                if(this.blackIdx>1){
                    this.blackIdx=0;
                    this.black=!this.black;
                }
                this.blackIdx++;
                return this.black;
            },
            findInicioSemana(){
                var fecha=new Date(this.fecha.getTime());
                fecha.setDate(fecha.getDate()-fecha.getDay());
                return fecha.getDate();
            },
            findFinSemana(){
                var fecha=new Date(this.fecha.getTime());
                fecha.setDate(fecha.getDate()+(6-fecha.getDay()));
                return fecha.getDate();
            },
            findWeek(  ) {
                var fecha=new Date(this.fecha.getTime());
                var dayNr   = (fecha.getDay() + 6) % 7;
                fecha.setDate(fecha.getDate() - dayNr + 3);
                var jan4    = new Date(fecha.getFullYear(), 0, 4);
                var dayDiff = (fecha - jan4) / 86400000;
                var weekNr = 1 + Math.ceil(dayDiff / 7);
                return weekNr;
                },
            loadGanadores(week){
                const w = week?week:this.semanaActual;
                https.get({
                    hostname: 'dev-sodigital.mx',
                    port: 5553,
                    path: `/ganadores?week=${w}`,
                    agent: false
                },(res)=>{
                    var body = '';
                    res.on('data',(d)=>{
                        body += d;
                    });
                    res.on('end', () =>{
                        let respuesta=JSON.parse(body);
                        this.ganadoresTop=[];
                        this.ganadoresRaw=respuesta._embedded.ganadores;
                    });
                });
            }
        },
        mounted(){
            this.semanaActual=36;
            this.loadGanadores();
        }
    }
</script>
<style scoped>
    h1{
        font-weight: normal;
    }
    select{
        width: auto;
        margin: 0 0 45px;
        padding: 10px 70px;
        font-size: 18px;
    }
</style>