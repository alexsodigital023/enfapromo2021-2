<template>
    <div :class="`alertmodal alert-${type}`" @click="close">
        <div class="marco11 alert-inner" @click="stopBubble">
            <div class="marco11-body">
                <div class="alert-header">
                    <i v-if="type=='error'" class="fa fa-times"></i>
                    <i v-if="type=='warning'" class="fa fa-exclamation"></i>
                    <i v-if="type=='info'" class="fa fa-info"></i>
                </div>
                <div class="alert-title">
                    {{title}}
                </div>
                <div class="alert-message">
                    {{message}}
                </div>
                <div class="alert-controls">
                    <button class='btn btn-rojo' @click="close">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            type:null,
            title:null,
            message:null
        },
        methods: {
            stopBubble(ev){
                ev.preventDefault();
                ev.stopPropagation();
            },
            close(){
                this.$emit('close');
            }
        }
    }
</script>
