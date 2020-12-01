<template>
    <div>
        <input type="text" :value="value" ref="box" class="form-control" placeholder="Buscar"  @input="update()">
    </div>
</template>

<script>
    export default {
        props:['value'],
        data(){
            return {
                timeout:null
            };
        },
        watch:{
        },
        methods:{
            update(){
                if(this.timeout){
                    clearTimeout(this.timeout);
                    this.timeout=null;
                }
                this.timeout=setInterval(()=>{
                    if(this.$refs.box.value!=this.value){
                        const search=this.getSearch();
                        search.search=this.$refs.box.value;
                        const s=[];
                        for(let i in search){
                            s.push(`${i}=${search[i]}`);
                        }
                        let url=`${url,window.location.protocol}//${url,window.location.host}${url,window.location.pathname}?${s.join('&')}`;
                        //console.log(url);
                        window.location.href=url;
                }
                },1000);
            },
            getSearch(){
                const search={};
                const t=/[a-z0-9_-]*=[a-z0-9_-]*/ig;
                if(window.location.search&&window.location.search.length>3){
                    const s=window.location.search.match(t);
                    for( let i in s){
                        var a=s[i].split('=',2);
                        search[a[0]]=a[1];
                    }
                }
                return search;
            }
        },
        mounted() {
        }
    }
</script>
<style scoped>
</style>