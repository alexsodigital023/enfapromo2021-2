<template>
    <div class="links" @mouseover="activo=true" @mouseleave="activo=false">
        <ul :class="activo?'activo':''">
            <li class="lengueta"><i class="fa fa-shopping-cart"></i> <span>¡Compra Aquí!</span></li>
            <li v-for="(t,i) in tiendas" :key="i" :class="t['css-class']" @click="goClick">
                <a :href="t.href" target="_blank">
                    <img :src="t.logo" class="logo-tienda">
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                tiendas:[],
                activo:false
            };
        },
        methods:{
            goClick(ev){
                console.log($(ev.target).find("a"));
                $(ev.target).find("a").click();
            }
        },
        mounted() {
            for(let i in this.$slots.default){
                if(this.$slots.default[i].tag=='t'){
                    this.tiendas.push(this.$slots.default[i].data.attrs);
                }
            }
        }
    }
</script>

<style scoped>
 .links{
     position:fixed;
     right:0;
     top:110px;
     z-index:200;
 }
 ul{
     padding:0;
     margin:0 -150px 0 0;
     transition: 0.5s all;
 }
 ul.activo{
     margin:0;
     width:260px;
 }
 li{
    padding: 0;
     margin:1px 0 0 40px;
     list-style:none;
    position:relative;
    left:80px;
     transition: 0.5s all;
    border-top-left-radius: 30px;
    border-bottom-left-radius: 30px;
 }
 li a{
    padding: 0px 10px;
     background:#fff;
     text-align:left;
    font-size: 20px;
    width:100%;
    display:inline-block;
    border-top-left-radius: 30px;
    border-bottom-left-radius: 30px;
    height:75px;

 }
 ul.activo li{
     left:0;
     height:67px;
     overflow:hidden;
 }
 li .logo-tienda{
     height:70px;
     display:inline;
 }
 li.lengueta{
    padding: 10px 10px;
    margin:0;
    background:#e5000f;
    color: #fff;
    cursor:pointer;
    left:-30px;
    height:60px;
 }
 li.lengueta i{
     text-align:center;
    background:#fff;
    color:#3c1b1a;
    font-size: 25px;
    width: 40px;
    padding: 8px 0;
    border-radius: 22px;
 }
 li.enfa a{
     background:#083a6f;
 }
 li.walmart a{
     background:#ffffff;
 }
 li.chedraui a{
     background:#f57b00;
 }
 li.mercado a{
     background:#ffe500;
 }
</style>
