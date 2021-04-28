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
                fields:{},
                buttons:{},
                values:{},
                aclCampos:{
                    'emailInput':true,
                    'nombreInput':true,
                    'apellidoInput':true,
                },
                stage:0,
                buttonsBinded:false,
                fileFieldBinded:false
            };
        },
        watch:{
	        stage(){
                this.bindFields();
                this.mapInputs();
                this.bindButtons();
                switch(this.stage){
                    case 1:
                        $(this.buttons.next).show();
                    break;
                    case 2:
                        $(this.buttons.next).hide();
                        break;
                }
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
                            let fileField = this.fields.file;
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
                if(!this.conexion){
                    this.conexion=new Conexion({
                        auth:{
                            host : {
                                host: 'chocomilkpromo-54hks.ondigitalocean.app',
                                port: '443',
                                path:'/api/user',
                            }
                        },
                        socket:{
                            host:{
                                host:'chocomilkpromo-54hks.ondigitalocean.app',
                                port:'443',
                                path:'/chocomilkpromosocket',
                                protocol: 'wss'
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
                        this.openSocket(con,$(this.fields.email).val()).then(
                            s=>{
                                console.log("======conexión abierta");
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
                        this.fields["apellido"]=$(this.$el).find("#name_Lastname").get(0);
                        this.fields["telefono"]=$(this.$el).find("#Phone").get(0);
                        this.fields["email"]=$(this.$el).find("#email").get(0);
                        this.fields["toc"]=$(this.$el).find("#lds_url_01_ConsentAccepted_0").get(0);
                        this.fields["pp"]=$(this.$el).find("#lds_url_02_ConsentAccepted_0").get(0);
                        this.fields["age"]=$(this.$el).find("#age_verification_0").get(0);
                        this.buttons["next"]=$(this.$el).find("a.xActionNext").get(0);
                        this.buttons["prev"]=$(this.$el).find("a.xActionPrevious").get(0);
                        break;
                    case 2:
                        this.fields["file"]=$(this.$el).find("#ngxUserUpload").get(0);
                        break;
                }
            },
            bindFields(){
                if(!this.fileFieldBinded && this.fields["file"]){
                    $(this.fields["file"]).change(()=>{
                        this.validate().then(
                            ok=>{
                                this.send().then(ok=>{
                                    $(this.buttons["next"]).show();
                                },error=>console.log(error));
                            },error=>{
                                console.error(error);
                            }
                        );
                    });
                    this.fileFieldBinded=true;
                }
            },
            bindButtons(){
                if(!this.buttonsBinded){
                    $(this.buttons["next"]).click((ev)=>{
                        this.nextStage(ev);
                    });
                    $(this.buttons["prev"]).click((ev)=>{
                        this.prevStage(ev);
                    });
                    this.buttonsBinded=true;
                }
            },
            nextStage(ev){
                this.validate().then(
                    ok=>{
                        this.stage++;
                        this.getConexion().then(ok=>console.log(ok),error=>console.error(error));
                    },error=>{
                        ev.preventDefault();
                        ev.stopPropagation();
                        $(this.fields[error.campo]).parents(".xFieldItem").addClass("xFieldError");
                        console.error("Error de validación",error);
                    }
                );
            },
            prevStage(ev){
                this.stage--;
            },
            validate(){
                return new Promise((resolve,reject)=>{
                    let values=this.getValues();
                    switch(this.stage){
                        case 1:
                            for(let i in values){
                                switch(i){
                                    case "nombre":
                                    case "apellido":
                                    case "telefono":
                                    case "email":
                                        if(!values[i]||values[i].legth < 1){
                                           return  reject({
                                                campo:i,
                                                value:values[i]
                                            });
                                        }
                                        break;
                                    case "toc":
                                    case "pp":
                                    case "age":
                                        if(!values[i]){
                                            return reject({
                                                campo:i,
                                                value:values[i]
                                            });
                                        }
                                        break;
                                }
                            }
                            return resolve();
                            break;
                        case 2:
                            if(!values.file||values.file.legth < 1){
                                return  reject({
                                    campo:'file',
                                    value:values.file
                                });
                            }
                            return resolve();
                            break;
                        default:
                            return resolve();
                    }
                });
            },
            getValues(){
                for(let i in this.fields){
                    switch(i){
                        case "toc":
                        case "pp":
                        case "age":
                            this.values[i]=$(this.fields[i]).prop("checked");
                            break;
                        default:
                            this.values[i]=$(this.fields[i]).val();
                            break;
                    }
                }
                return this.values;
            }
        },
        mounted() {
            this.stage=1;
        }
    }
</script>
