<template>
    <button @click="abrirModal" class="btn btn-primary" title="verTicket"><i class="fa fa-eye"></i></button>
</template>

<script>
    export default {
        props:{
            image:null
        },
        methods:{
            abrirModal(){
                $.get(this.image,(resp)=>{
                    this.$emit("show",resp.data);
                });
            }
        },
        mounted() {
        }
    }
</script>
