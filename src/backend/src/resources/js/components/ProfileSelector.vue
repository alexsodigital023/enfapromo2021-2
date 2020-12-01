<template>
    <select class="form-control" :value="value" v-on:change="change($event.target.value)">
        <option v-for="p in profiles" :value="p.id">{{p.name}}</option>
    </select>
</template>

<script>
    export default {
        props:{
            value:null,
            profiles:null
        },
        data(){
            return {
            };
        },
        watch:{
        },
        methods:{
            change(value){
                this.$emit("change",value);
            }
        },
        mounted() {
        }
    }
</script>
<style scoped>
</style>