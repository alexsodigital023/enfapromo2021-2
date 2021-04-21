<template>
    <div :class="`ticketFormContainer`">
        <slot></slot>
    </div>
</template>

<script>
import Conexion from '../conexion';
import Cookies from 'js-cookie';

    export default {
        data(){
            return {
                fields:[],
                submitButton:null,
                fileInput:null,
                conexion:null,
                emailInput:null,
                nombreInput:null,
                apellidoInput:null,
                diaInput:null,
                mesInput:null,
                anyoInput:null,
                ticketValue:null,
                celularInput:null,
                file:null,
                email:null,
                nombre:null,
                apellido:null,
                dia:null,
                mes:null,
                anyo:null,
                stage:0,
                fileSended:false,
                enviando:false,
                submit:null,
                aclCampos:{
                    'emailInput':true,
                    'nombreInput':true,
                    'apellidoInput':true,
                }
            };
        },
        watch:{
	        stage(){
                this.mapInputs();
                console.log("cambio de stage",this.stage);
            }
        },
        methods:{
            endStage(){
                console.log("stage :",this.stage);
                switch(this.stage){
                    case 0:
                        $(this.emailInput).change(()=>this.dataChanged());
                        $(this.nombreInput).change(()=>this.dataChanged());
                        $(this.apellidoInput).change(()=>this.dataChanged());
                        $(this.celularInput).change(()=>this.dataChanged());
                        this.stage++;
                        break;
                    case 1:
                        if(this.file&&this.email){
                            this.send().then(ok=>{
                                console.log(ok);
                                this.stage++;
                                this.dataChanged();
                            },error=>console.log(error));
                        }
                        break;
                    case 2:
                        this.email?this.updateTicket('email',this.email):null;
                        this.nombre?this.updateTicket('nombre',this.nombre):null;
                        this.apellido?this.updateTicket('apellido',this.apellido):null;
                        !isNaN(parseInt(this.dia))?this.updateTicket('dia',this.dia):0;
                        this.mes?this.updateTicket('mes',this.mes):null;
                        !isNaN(parseInt(this.anyo))?this.updateTicket('anyo',this.anyo):null;
                        break;
                }
            },
            showError(type,title,message){
                this.$emit('error',{
                    type:type,
                    title:title,
                    message:message
                });
            },

            updateTicket(nombre,valor){
                if(this.aclCampos[nombre]){
                    this.enviando=true;
                    this.getConexion().then(
                        con=>{
                            con.send('updateTicket',{
                                name:nombre,
                                value:valor
                            }).then(
                                ok=>this.enviando=false,
                                error=>{
                                    console.error(error);
                                    this.enviando=false;
                                }
                            )
                        },error=>{
                            this.enviando=false;
                            this.showError('error','Error de Conexión', 'Por favor intenta más tarde');
                        }
                    )
                }
            },
            fileChanged(){
                this.file=$(this.fileInput).find("input[type='file']").val().length>0;
                this.endStage();
            },
            dataChanged(){
                this.email=$(this.emailInput).val().length>0?$(this.emailInput).val():null;
                this.nombre=$(this.emailInput).val().length>0?$(this.nombreInput).val():null;
                this.apellido=$(this.emailInput).val().length>0?$(this.apellidoInput).val():null;
                this.dia=$(this.emailInput).val().length>0?$(this.diaInput).val():null;
                this.mes=$(this.emailInput).val().length>0?$(this.mesInput).val():null;
                this.anyo=$(this.emailInput).val().length>0?$(this.anyoInput).val():null;
                this.endStage();
            },
            updateStatus(status){
                $(this.ticketValue).val(status.import)
            },
            send(){
                return new Promise((resolve,reject)=>{
                    if(this.enviando){
                        return reject("ya se esta enviando");
                    }
                    this.$emit("working",{
                        percent:'Subiendo Ticker',
                        status:0,
                        message:'Espere...'
                    });
                    this.enviando=true;
                    this.getConexion().then(
                        con=>{
                            this.$emit("working",{
                                percent:'50%',
                                status:50,
                                message:'Espere...'
                            });
                            let fileField = $(this.fileInput).find("input[type='file']").get(0);
                            for(let i in fileField.files){
                                if(fileField.files[i]&&fileField.files[i].size){
                                    const reader = new FileReader();
                                    this.$emit("working",{
                                        percent:'75%',
                                        status:50,
                                        message:'Espere...'
                                    });
                                    reader.onload = (e)=>{
                                        con.sendFile(e.target.result,(update)=>{
                                                this.fileSended=true;
                                                this.$emit("stop");
                                                this.enviando=false;
                                                this.updateStatus(update);
                                                resolve(update);
                                            }).then(
                                            resp=>{
                                                this.$emit("stop");
                                                this.enviando=false;
                                                this.updateStatus(resp);
                                                this.fileSended=true;
                                                resolve(update);
                                            },
                                            error=>{
                                                this.ticketStatus=2;
                                                this.enviando=false;
                                                this.showError('error','Archivo incorrecto', 'Este ticket está duplicado o es de un formato que no podemos aceptar');
                                                this.$emit("stop");
                                                this.fileSended=false;
                                                resolve(update);
                                            }
                                        );
                                    }
                                    reader.readAsArrayBuffer(fileField.files[i]);
                                }
                            }
                        },error=>{
                            this.showError('error','Error de Conexión', 'Por favor intenta más tarde');
                            this.enviando=false;
                            this.$emit("stop");
                            this.ticketStatus=2;
                        });
                });
            },
            
            getConexionObject(){
                console.log('!!');
                if(!this.conexion){
                    this.conexion=new Conexion({
                        auth:{
                            host : {
                                host: 'localhost',
                                port: '8085',
                                path:'/',
                            }
                        },
                        socket:{
                            host:{
                                host:'localhost',
                                port:'3000',
                                path:'/',
                                protocol: 'ws'
                            }
                        }
                    });
                }
                return this.conexion;
            },
            getConexion(){
                return new Promise((resolve,reject)=>{
                    if(this.conexion&&this.conexion.conectado){
                        resolve(this.conexion);
                    }else{
                        let con = this.getConexionObject();
                        con.registerTimeoutHandler(()=>{
                            if(this.enviando){
                                this.$emit('stop');
                                this.showError('error','Error de Conexión', 'Por favor intenta más tarde');
                            }
                            reject('timeout');
                        });
                        this.openSocket(con,this.email).then(
                            s=>{
                                this.conexion=con;
                                resolve(this.conexion);
                            },error=>reject(error)
                        );
                    }
                });
            },
            openSocket(con,uuid){
                return new Promise((resolve,reject)=>{
                    con.open(uuid).then(
                        socket=>resolve(socket),
                        error=>reject(error)
                    );
                });
            },
            mapInputs(){
                switch(this.stage){
                    case 1:
                        this.fields["nombre"]=$(this.$el).find("#name_Firstname").get(0);
                        break;
                }
                console.log("Campos iniciados", this.fields);
            }
        },
        mounted() {
            this.stage=1;
            console.log("Iniciando");
            return;
            this.submitButton=$(this.$el).find("#xSubmitContainer").get(0);
            this.fileInput=$(this.$el).find("#ngxUserUploadWrapper").get(0);
            this.celularInput=$(this.$el).find("#Phone").get(0);
            this.fileInput=$(this.$el).find("#ngxUserUpload").get(0);
            this.emailInput=$(this.$el).find("#email").get(0);
            this.nombreInput=$(this.$el).find("#name_Firstname").get(0);
            this.apellidoInput=$(this.$el).find("#name_Lastname").get(0);
            this.diaInput=$(this.$el).find("#date_of_birth_day").get(0);
            this.mesInput=$(this.$el).find("#date_of_birth_month").get(0);
            this.anyoInput=$(this.$el).find("#date_of_birth_year").get(0);
            this.ticketValue=$(this.$el).find("#ticketValue").get(0);
        }
    }
</script>
