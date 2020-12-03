<template>
    <div :class="`alertmodal`" @click="close">
        <div class="marco11 alert-inner" @click="stopBubble">
            <div class="marco11-body">
                <div class="alert-message">
                   <iframe  :src="url"></iframe>
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
            url:null,
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
