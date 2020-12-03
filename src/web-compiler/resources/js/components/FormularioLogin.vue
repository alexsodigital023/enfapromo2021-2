<template>
    <div class="formularioLogin">
        <div class="header image-container">
            <slot name="header"></slot>
        </div>
        <div class="body marco3">
            <div class="marco3-content">
                <i v-if="formulario=='login'||formulario=='registrar'" class="medallon medallon-people"></i>
                <i v-if="formulario=='ticket'" class="medallon medallon-ticket"></i>
                <form v-if="formulario=='login'">
                    <div class="field field-email">
                        <input type="email" placeholder="E-mail">
                    </div>
                    <div class="field field-password">
                        <input type="password" placeholder="Contraseña">
                    </div>
                    <div class="passRecovery">
                        <slot name="passrecovery"></slot>
                    </div>
                </form>
                <form v-if="formulario=='registrar'" class="form-registrar">
                    <div class="field field-nombre">
                        <input type="text" placeholder="Nombre Completo">
                    </div>
                    <div class="col">
                        <div class="field field-email">
                            <input type="email" placeholder="E-mail">
                        </div>
                    </div>
                    <div class="col">
                        <div class="field field-phone">
                            <input type="text" placeholder="Teléfono">
                        </div>
                    </div>
                    <div class="field field-password">
                        <input type="password" placeholder="Contraseña">
                    </div>
                    <div class="field field-toc">
                        <label class="legalLink">
                            <input type="radio" class="field-option">
                            <slot name="toc"></slot>
                        </label>
                        <label  class="legalLink">
                            <input type="radio" class="field-option">
                            Soy mayor de edad
                        </label>
                    </div>
                </form>
                <div  v-if="formulario=='login'" class="botones">
                    <div class="row1 row">
                        <div class="col">
                            <button class="btn btn-verde">Entrar</button>
                        </div>
                        <div class="col">
                           <button class="btn btn-rojo" @click="showRegistrar">Crear Cuenta</button>
                        </div>
                    </div>
                    <div class="row row2">
                        <div class="col">
                            <button class="btn btn-azulClaro btn-facebook">
                                <i class="fa fa-facebook-f"></i>
                                Ingresar con Facebook
                            </button>
                        </div>
                    </div>
                    <div class="row row3">
                        <div class="col">
                            <button class="btn btn-amarillo" @click="showTicket">
                                <i class="fas fa-receipt"></i>
                                SubirTicket
                            </button>
                        </div>
                    </div>
                </div>
                <div  v-if="formulario=='registrar'" class="botones">
                    <div class="row1 row">
                        <div class="col">
                        </div>
                        <div class="col">
                           <button class="btn btn-rojo" @click="showRegistrar">Crear Cuenta</button>
                        </div>
                    </div>
                </div>
                <form v-if="formulario=='ticket'" class="ticketForm">
                    <div class="row row-5">
                        <div class="col">
                            <div class="field field-email">
                                <input type="email" placeholder="E-mail" v-model="email">
                            </div>
                        </div>
                    </div>

                    <div class="row row-5">
                        <div  class='fileSelector'>
                        <input :disabled="!email" type="file" ref='ticket' @change='enviarTicket' accept="image/*,application/pdf">
                        </div>
                        <button  :disabled="!email" :class="`btn ${email?'btn-amarillo':''}`">Buscar Imagen</button>
                    </div>
                    <div class="row row-5">
                        <button class="btn btn-azulClaro">Registra tu Ticket</button>
                    </div>
                    <div class="row row-5">
                        <div class="col col-1">
                            <div class="field field-ticket">
                                <input type="text" placeholder="Número de ticket">
                            </div>
                        </div>
                    </div>
                    <div class="row row-10">
                        <div class="col col-5">
                            <div class="field field-estado">
                                <select placeholder="estado">
                                    <option v-for="(e,i) in estados" :key='i' :value="i">{{e}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-5">
                            <div class="field field-cadena">
                                <select placeholder="cadena">
                                    <option v-for="(e,i) in tiendas" :key='i' :value="i">{{e}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-10">
                        <div class="col col-3">
                            <div class="field field-anyo">
                                Año: {{year}}
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="field field-mes">
                                <select placeholder="mes" v-model="mes">
                                    <option v-for="(e,i) in meses" :key='i' :value="i">{{e}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col col-3">
                            <div class="field field-dia">
                                <select placeholder="día" v-model="dia">
                                    <option v-for="(e,i) in dias" :key='i' :value="e">{{e}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row row-10">
                        captcha
                    </div>
                    <div class="row row-5">
                        <button class="btn btn-verde">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Conexion from '../conexion';

    export default {
        data(){
            return {
                formulario:'ticket',
                year:2020,
                mes:null,
                dia:null,
                email:null,
                conexion:null,
                estados:[
                    'Estado',
                    'Estado de Pánico',
                    'Estado Mayor',
                    'Estado que no está'
                ],
                tiendas:[
                    'Tienda 1',
                    'Tienda 2',
                    'Tienda 3',
                    'Tienda 4',
                ],
                meses:[
                    'ENERO',
                    'FEBRERO',
                    'MARZO',
                    'ABRIL',
                    'MAYO',
                    'JUNIO',
                    'JULIO',
                    'AGOSTO',
                    'SEPTIEMBRE',
                    'OCTUBRE',
                    'NOVIEMBRE',
                    'DICIEMBRE',
                ],
                dias:[],
                conexion:null
            };
        },
        watch:{
            mes(){
                const final=new Date(this.year, this.mes+1, 0).getDate();
                this.dias=[];
                for(let i=1;i<=final;i++){
                    this.dias.push(i);
                }
            }
        },
        methods:{
            getConexionObject(){
                if(!this.conexion){
                    this.conexion=new Conexion({
                        auth:{
                            host:{
                                host:'localhost',
                                port:'8085',
                                path:'/user'
                            }
                        },
                        socket:{
                            host:{
                                host:'localhost',
                                port:'1000',
                                protocol:'ws'
                            },
                            protocol:''
                        }
                    });
                }
                return this.conexion;
            },
            showRegistrar(){
                this.formulario='registrar';
            },
            showTicket(){
                this.formulario='ticket';
            },
            openSocket(con,uuid){
                return new Promise((resolve,reject)=>{
                    con.open(uuid).then(
                        socket=>resolve(socket),
                        error=>reject(error)
                    );
                });
            },
            getConexion(){
                return new Promise((resolve,reject)=>{
                    if(this.conexion&&this.conexion.conectado){
                        resolve(this.conexion);
                    }else{
                        let con = this.getConexionObject();
                        this.openSocket(con,this.email).then(
                            s=>{
                                this.conexion=con;
                                resolve(this.conexion);
                            },error=>reject(error)
                        );
                    }
                });
            },
            enviarTicket(){
                this.getConexion().then(
                    con=>{
                        for(let i in this.$refs.ticket.files){
                            if(this.$refs.ticket.files[i]&&this.$refs.ticket.files[i].size){
                                const reader = new FileReader();
                                reader.onload = (e)=>{
                                    con.sendFile(e.target.result).then(
                                        ok=>console.log('enviado'),
                                        error=>console.error(error)
                                    );
                                }
                                reader.readAsArrayBuffer(this.$refs.ticket.files[i]);
                            }
                        }
                    },error=>console.error(error)
                );
            }
        },
        mounted() {
            const d=new Date();
            this.mes=d.getMonth();
            this.dia=d.getDate();
        }
    }
</script>
<style scoped>
    .ticketForm{
        margin:20px 30px;
    }
    .header img{
        width:100%;
        height:100%;
    }
    .formularioLogin{
        max-width:450px;
        margin:0 auto;
        text-align:left;
    }
    .marco3{
        margin-top:100px;
        text-align:center;
    }
    form{
        text-align:left;
    }
    .medallon{
        margin-top:-50px;
    }
    .passRecovery{
        padding: 3px 10px;
        font-size: 12px;
    }
    .btn{
        width:100%;
        border-radius:5px;
    }
    .botones .row{
        margin:5px 0;
    }
    .botones .row1 .col{
        width:48%;
    }
    .botones .row2 .col{
        width:97%;
    }
    .form-registrar .col{
        margin:0 10px;
        width:44%;
    }
    .fileSelector{
        position:absolute;
        text-align:center;
        width:380px;
        height:25px;
        opacity:0;
    }
    .fileSelector input{
        width:100%;
        height:100%;
    }
</style>