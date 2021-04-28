<template>
    <div v-click-outside ="clickExterno" :class="cssClass">
        <nav>
            <ul>
                <li class="outer-menu">
                    <a href="https://app.wayin.com/preview/experience/7c606ec2-435f-4eb4-a0fa-c852c5e0006c/236633/details">
                        <i class="icon icon-control"></i>
                        <p>Juega</p>
                    </a>
                    <a href="https://app.wayin.com/preview/experience/7c606ec2-435f-4eb4-a0fa-c852c5e0006c/236633/prizes">
                        <i class="icon icon-regalo"></i>
                        <p>Premios</p>
                    </a>
                </li>
                <div v-if="visible" @click="myMethod">
                    <div class="menuIcono"></div>
                </div>
                <li @click="clickExterno">
                    <slot></slot>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import vClickOutside from 'v-click-outside'
    export default {
        directives: {
            clickOutside: vClickOutside.directive
        },
        props:{
            cssClass:null,
            current:null
        },
        data(){
            return {
                tamano:null,
                visible:true
            }
            
        },
        methods:{
            clickExterno (event) {
                if(this.visible==false){
                    document.getElementById('xSectionHeader').style.display = "none";
                    this.visible=true;
                }
            },
            myMethod () {	
    	        document.getElementById('xSectionHeader').style.display = "block";
                this.visible=false
            },
            menuVisible(){
                if(document.getElementById('xSectionHeader').style.display = "none"){
                    return false;
                }
            },
            resize(){
            },
            makeBig(){

            },
            makeSmall(){
            }
        },
        created() {
            $(window).bind('resize',()=>{
                this.resize();
            })
        },
        mounted() {
               this.resize();
               
        },
    }
</script>
