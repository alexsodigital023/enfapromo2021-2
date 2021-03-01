<template>
    <div class="row form-group">
        <div class="col-sm col-1">
            <button class="btn btn-sm btn-circle btn-info" @click="current--"><i class="fa fa-chevron-left"></i></button>
        </div>
        <div class="col-sm">
            {{current}}
        </div>
        <div class="col-sm col-1">
        <button class="btn btn-sm btn-circle btn-info" @click="current++"><i class="fa fa-chevron-right"></i></button>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            value:null
        },
        data(){
            return {
                current:null
            };
        },
        watch:{
            current(){
                if(this.current&&this.current!=this.value){
                    const search=this.getSearch();

                    if(!search||(search.week!=this.current&&this.value!=this.current)){
                        search.week=this.current;
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
            this.current = +this.value;
        }
    }
</script>
<style scoped>
.col-sm{
    vertical-align:middle;
}
</style>