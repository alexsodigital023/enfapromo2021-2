<template>
    <div class="headerMain">
        <div v-if="tamano==1&&false" class="promoGana">
            <div class="imagen">
                <img src="https://a.wayin.com/images/5365/4a7db5cb-b312-48ad-87c7-bb126fef06f7/premio.png" alt="Premio Mayor">
            </div>
            <h1>¡Compra, Registra y Gana!</h1>
            <p>Tu participación ayuda a cumplir el sueño de miles de niños.</p>
        </div>
        <div class="header">
            <div  v-if="tamano==1" class="xCampaignHeader showMenuBar">
                <i class="fa fa-bars" @click="visible=!visible"></i>
                <img src="https://a.wayin.com/images/5365/4a7db5cb-b312-48ad-87c7-bb126fef06f7/logoNutri.png" alt="Nutrisueños">
            </div>
            <div  ref="original">
                <slot></slot>
            </div>
            <div v-if="tamano==2" class="logo marcoDorado col">
                <a data-ngx-action="route:details">
                    <img src="https://a.wayin.com/images/5365/4a7db5cb-b312-48ad-87c7-bb126fef06f7/logo.png" alt="Cal-c-tose">
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            cssClass:null
        },
        data(){
            return {
                tamano:null,
                visible:false,

                ticketButton:null,
                nutreButton:null
            }
        },
        created() {
            $(window).bind('resize',()=>{
                this.resize();
            })
        },
        watch:{
            visible(){
                console.log("visible")
                if(this.visible){
                    $(this.$refs.original).show();
                }else{
                    $(this.$refs.original).hide();
                }
            },
            tamano(){
                switch(this.tamano){
                    case 1:
                        this.makeSmall();
                        break;
                    case 2:
                        this.makeBig();
                        break;
                }
            }
        },
        methods:{
            resize(){
                if($(this.$el).width()<600){
                    this.tamano=1;
                }else{
                    this.tamano=2;
                }
            },
            reset(){

            },
            makeBig(){
                $(this.$refs.original).show();
                this.ticketButton=$(this.$el).find("ul.xNavMain").find("li.nav").first();
                this.nutreButton=$(this.$el).find("ul.xNavMain").find("li.nav").last();
                $(this.ticketButton).find(".xTabInner").text('Registrar Ticket');
                $(this.ticketButton).find("a").addClass("btn").addClass("btn-guinda");
                $(this.nutreButton).find("a").addClass("btn").addClass("btn-azul");
                $(this.$el).find("ul.xNavMain").append(this.ticketButton);
            },
            makeSmall(){
                this.visible=false;
                $(this.$refs.original).hide();
            }
        },
        mounted() {
            this.resize();
        }
    }
</script>
