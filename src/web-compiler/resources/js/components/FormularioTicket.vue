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
                pages:{},
                buttons:{},
                values:{},
                aclCampos:{
                    'nombre':true,
                    'apellido':true,
                    'telefono':true,
                    'email':true,
                    'game_t':true,
                    'game_m':true,
                },
                stage:0,
                buttonsBinded:false,
                fileFieldBinded:false
            };
        },
        watch:{
	        stage(){
                this.mapPages();
                this.mapInputs();
                this.bindFields();
                this.bindButtons();
                switch(this.stage){
                    case 1:
                        $(this.buttons.prev).hide().addClass("xHidden");
                        $(this.buttons.next).show().removeClass("xHidden");
                        $(this.buttons["submit"]).addClass("xHidden");
                        $(this.pages[1]).show();
                        $(this.pages[2]).hide();
                        $(this.pages[3]).hide();
                    break;
                    case 2:
                        $(this.buttons.prev).show().removeClass("xHidden");
                        $(this.buttons.next).hide().addClass("xHidden");
                        $(this.buttons["submit"]).addClass("xHidden");
                        $(this.pages[1]).hide();
                        $(this.pages[2]).show();
                        $(this.pages[3]).hide();
                        break;
                    case 3:
                        $(this.buttons.prev).show().removeClass("xHidden");
                        $(this.buttons.next).hide().addClass("xHidden");
                        $(this.buttons["submit"]).removeClass("xHidden");
                        $(this.pages[1]).hide();
                        $(this.pages[2]).hide();
                        $(this.pages[3]).show();
                        break;
                }
            }
        },
        methods:{
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
                                        console.log("enviando archivo");
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
                                host: 'chocomilk.free.beeceptor.com',
                                port: '443',
                                path:'/appv1/user',
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
            mapPages(){
                this.pages[1]=$(this.$el).find(".xFormPage.n1").get(0);
                this.pages[2]=$(this.$el).find(".xFormPage.n2").get(0);
                this.pages[3]=$(this.$el).find(".xFormPage.n3").get(0);
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
                        this.fields["game_t"]=$(this.$el).find("#game_t").get(0);
                        this.fields["game_m"]=$(this.$el).find("#game_m").get(0);
                        this.buttons["next"]=$(this.$el).find("a.xActionNext").get(0);
                        this.buttons["prev"]=$(this.$el).find("a.xActionPrevious").get(0);
                        this.buttons["submit"]=$(this.$el).find(".xActivateContainer").get(0);
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
                                    this.updateTicket("nombre",$(this.fields["nombre"]).val());
                                    this.updateTicket("apellido",$(this.fields["apellido"]).val());
                                    this.updateTicket("telefono",$(this.fields["telefono"]).val());
                                    this.updateTicket("email",$(this.fields["email"]).val());
                                    console.log("archivo enviado");
                                    $(this.buttons["next"]).show().removeClass("xHidden");
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
