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
                file:null,
                email:null,
                stage:0
            };
        },
        watch:{
            
        },
        methods:{
            endStage(){
                switch(this.stage){
                    case 0:
                        $(this.fileInput).find("input").change(()=>this.fileChanged());
                        $(this.emailInput).change(()=>this.emailChanged());
                        //$(this.submitButton).hide();
                        this.stage++;
                        break;
                    case 1:
                        if(this.file&&this.email){
                            this.stage++;
                            this.send();
                        }
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

            fileChanged(){
                this.file=$(this.fileInput).find("input[type='file']").val().length>0;
                this.endStage();
            },
            emailChanged(){
                this.email=$(this.emailInput).val().length>0?$(this.emailInput).val():null;
                this.endStage();
            },

            send(){
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
                                            this.$emit("stop");
                                            this.enviando=false;
                                            this.updateStatus(update)
                                        }).then(
                                        resp=>{
                                            this.$emit("stop");
                                            this.enviando=false;
                                            this.updateStatus(resp);
                                        },
                                        error=>{
                                            this.ticketStatus=2;
                                            this.enviando=false;
                                            this.showError('error','Archivo incorrecto', 'Este ticket está duplicado o es de un formato que no podemos aceptar');
                                            this.$emit("stop");
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
            },
            
            getConexionObject(){
                if(!this.conexion){
                    this.conexion=new Conexion({
                        auth:{
                            host:{
                                host:'dev-sodigital.mx',
                                port:'8085',
                                path:'/user'
                            }
                        },
                        socket:{
                            host:{
                                host:'enfa-goldenticket-socket-k6r9k.ondigitalocean.app/',
                                port:'443',
                                protocol:'wss',
                                path:'/'
                            },
                            protocol:''
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
        },
        mounted() {
            this.submitButton=$(this.$el).find("#xSubmitContainer").get(0);
            this.fileInput=$(this.$el).find("#ngxUserUploadWrapper").get(0);
            this.emailInput=$(this.$el).find("#email").get(0);
            this.nombreInput=$(this.$el).find("#name_Firstname").get(0);
            this.apellidoInput=$(this.$el).find("#name_Lastname").get(0);
            this.diaInput=$(this.$el).find("#date_of_birth_day").get(0);
            this.mesInput=$(this.$el).find("#date_of_birth_month").get(0);
            this.anyoInput=$(this.$el).find("#date_of_birth_year").get(0);
            this.ticketValue=$(this.$el).find("#ticketValue").get(0);
            this.endStage();
        }
    }
</script>
