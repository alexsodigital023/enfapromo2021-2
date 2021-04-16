<template>
    <div :class="cssClass">
        <nav>
            <ul>
                <div v-if="visible" @click="myMethod">
                    <img style="width:40px;" src="../../images/icon_menu.png" id="test"/>
                </div>
                <li>
                    <slot></slot>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
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
                console.log('wiiii');
            },
            makeBig(){
                console.log("grande");

            },
            makeSmall(){
                console.log("pequeño");
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
