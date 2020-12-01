<template>

    <table class="table table-bordered table-responsive" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr v-if="statusId==11">
            <th colspan="5"></th>
            <th colspan="4">Lugar</th>
        </tr>
        <tr>
            <th>#</th>
            <th>Email</th>
            <th>Estado</th>
            <th>Tienda</th>
            <th>Status</th>
            <th v-if="statusId==11">1</th>
            <th v-if="statusId==11">2</th>
            <th v-if="statusId==11">3</th>
            <th v-if="statusId==11">N</th>
            <th v-if="statusId!=11">Productos</th>
            <th v-if="statusId!=11">Importe</th>
            <th>Semana</th>
            <th></th>
        </tr>
    </thead>
        <tbody>
            <tr v-if="t.status_id==statusId" v-for="t in tickets" :key="t.id" :class="`${!t.submited?'':''}`">
                <td>{{t.id}}</td>
                <td>{{t.email}}</td>
                <td>{{t.estado}}</td>
                <td>{{t.tienda}}</td>
                <td>{{t.status}}</td>
                <td v-if="t.status_id==11"><input type="radio" name="lugar1" :checked="t.prioridad==1" v-on:change="(ev)=>premiado(ev,t,1)"></td>
                <td v-if="t.status_id==11"><input type="radio" name="lugar2" :checked="t.prioridad==2" v-on:change="(ev)=>premiado(ev,t,2)"></td>
                <td v-if="t.status_id==11"><input type="radio" name="lugar3" :checked="t.prioridad==3" v-on:change="(ev)=>premiado(ev,t,3)"></td>
                <td v-if="t.status_id==11"><input type="checkbox" name="lugar4" :checked="t.prioridad>3" v-on:change="(ev)=>premiado(ev,t,99)"></td>
                <td v-if="t.status_id!=11">{{t.product}}</td>
                <td v-if="t.status_id!=11">{{t.import}}</td>
                <td>{{t.semana}}</td>
                <td>
                    <div>
                        <ver-ticket :image="t.imagePath"></ver-ticket>
                        <ver-foto :image="t.foto"></ver-foto>
                    </div>
                    <div>
                        <aprobar-ticket v-if="t.status_id!=3&&t.status_id!=11" v-on:aprobado="(ev)=>{aprobado(ev,t);}"></aprobar-ticket>
                        <rechazar-ticket v-if="t.status_id!=2&&t.status_id!=11" v-on:rechazado="(ev)=>{rechazado(ev,t);}"></rechazar-ticket>
                        <despremiar-ticket v-if="t.status_id==11" v-on:despremiado="(ev)=>{despremiado(ev,t);}"></despremiar-ticket>
                        <premiar-ticket v-if="t.status_id==3" v-on:premiado="(ev)=>{premiado(ev,t,99);}"></premiar-ticket>
                    </div>
                </td>
            </tr>
    </tbody>
    </table>
</template>

<script>
    export default {
        props:{
            statusId:null
        },
        data(){
            return {
                showModal:null,
                tickets:[]
            };
        },
        watch:{
        },
        methods:{
            aprobado(ev,t){
                $.post(t.aprobarPath,{
                    status:"aprobado"
                },(resp)=>{
                    if(resp.error){
                        alert(resp.message);
                        console.error(resp);
                        throw "Error en solicitud";
                    }
                    t.status_id=3;
                    t.status="Aceptado";
                });
            },
            rechazado(ev,t){
                $.post(t.rechazarPath,{
                    status:"Rechazado"
                },(resp)=>{
                    if(resp.error){
                        alert(resp.message);
                        console.error(resp);
                        throw "Error en solicitud";
                    }
                    t.status_id=2;
                    t.status="Rechazado";
                });
            },
            premiado(ev,t,prioridad){
                t.prioridad=prioridad;
                $.post(t.premiarPath,{
                    status:"Premiado",
                    prioridad:prioridad
                },(resp)=>{
                    if(resp.error){
                        alert(resp.message);
                        console.error(resp);
                        throw "Error en solicitud";
                    }
                    t.status_id=11;
                    t.status="Premiado";
                });
            },
            despremiado(ev,t){
                $.post(t.despremiarPath,{
                    status:"Aceptado"
                },(resp)=>{
                    if(resp.error){
                        alert(resp.message);
                        console.error(resp);
                        throw "Error en solicitud";
                    }
                    t.status_id=3;
                    t.status="Aceptado";
                });
            }
        },
        mounted() {
            for(var i in this.$slots.default){
                if(this.$slots.default[i].data){
                    this.tickets.push({
                        id:this.$slots.default[i].data.attrs.id,
                        email:this.$slots.default[i].data.attrs.email,
                        estado:this.$slots.default[i].data.attrs.estado,
                        tienda:this.$slots.default[i].data.attrs.tienda,
                        status_id:this.$slots.default[i].data.attrs.status_id,
                        status:this.$slots.default[i].data.attrs.status,
                        product:this.$slots.default[i].data.attrs.product,
                        import:this.$slots.default[i].data.attrs.import,
                        semana:this.$slots.default[i].data.attrs.semana,
                        imagePath:this.$slots.default[i].data.attrs.image,
                        foto:this.$slots.default[i].data.attrs.foto,
                        prioridad:this.$slots.default[i].data.attrs.prioridad,
                        aprobarPath:this.$slots.default[i].data.attrs.aprobar,
                        rechazarPath:this.$slots.default[i].data.attrs.rechazar,
                        premiarPath:this.$slots.default[i].data.attrs.premiar,
                        despremiarPath:this.$slots.default[i].data.attrs.despremiar,
                        submited:this.$slots.default[i].data.attrs.submited==1
                    });
                }
            }
        }
    }
</script>
<style scoped>
    .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .5);
    display: table;
    transition: opacity .3s ease;
    }

    .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
    }

    .modal-container {
    width: 500px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
    transition: all .3s ease;
    font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
    margin-top: 0;
    color: #42b983;
    }

    .modal-body {
    margin: 20px 0;
    }

    .modal-default-button {
    float: right;
    }

    /*
    * The following styles are auto-applied to elements with
    * transition="modal" when their visibility is toggled
    * by Vue.js.
    *
    * You can easily play with the modal transition by editing
    * these styles.
    */

    .modal-enter {
    opacity: 0;
    }

    .modal-leave-active {
    opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    }
</style>