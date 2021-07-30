<template>
    <select v-model="current" class="form-control">
        <option v-for="s in status" :value="s.id">{{s.name}}</option>
    </select>
</template>

<script>
    export default {
        props:{
            value:null
        },
        data(){
            return {
                current:null,
                status:[]
            };
        },
        watch:{
            current(){
                const search=this.getSearch();

                if(!search||(search.status!=this.current&&this.value!=this.current)){
                    search.status=this.current;
                    const s=[];
                    for(let i in search){
                        s.push(`${i}=${search[i]}`);
                    }
                    let url=`${url,window.location.protocol}//${url,window.location.host}${url,window.location.pathname}?${s.join('&')}`;
                    //console.log(url);
                    window.location.href=url;
                }
            }
        },
        methods:{
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
            this.current=this.value;
            for(var i in this.$slots.default){
                if(this.$slots.default[i].data){
                    this.status.push({
                        id:this.$slots.default[i].data.attrs.id,
                        name:this.$slots.default[i].data.attrs.name
                    });
                }
            }
        }
    }
</script>
<style scoped>
</style>