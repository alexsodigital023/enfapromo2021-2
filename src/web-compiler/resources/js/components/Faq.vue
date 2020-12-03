<template>
    <div class="marco7">
        <div class="marco7-header faq-header" @click="open=!open">
            {{pregunta}}
            <i v-if="!open" class="control fas fa-caret-down"></i>
            <i v-if="open" class="control fas fa-caret-up"></i>
        </div>
        <div class="marco7-content" v-if="open">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            pregunta:null
        },
        data:function(){
            return {
                open:false
            };
        },
        watch:{
            open(){
                this.open?
                this.$emit('open'):
                this.$emit('close');
            }
        },
        methods:{
            close(){
                this.open=false;
            }
        }
    }
</script>
<style scoped>
    .faq-header{
        cursor:pointer;
        border:1px solid #d8ddec;
    }
    .faq-header:hover{
        background:#d8ddec;
    }
    .control{
        float:right;
        cursor:pointer;
        font-size:20px;
        opacity:.9;
    }
    .control:hover{
        opacity:1;
    }
</style>
