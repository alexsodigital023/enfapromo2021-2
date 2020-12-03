<template>
    <div class="foto-slider" @mouseover="userHover=true" @mouseleave="userHover=false">
        <div class="left" @click="left"><i class="fa fa-angle-left"></i></div>
        <div class="right" @click="right"><i class="fa fa-angle-right"></i></div>
            <div class="slider-shadow-top"></div>
        <div class="slider-container" ref="container" v-touch:swipe.left="right" v-touch:swipe.right="left">
            <div ref="riel">
                <div v-for="(e,i) in items" :key="`item_${i}`" :class="`slider-item ${current==i?'current':''}  ${current<i?'siguiente':''} ${current>i?'anterior':''}`">
                    <div class="slider-item-wrapper">
                        <img :src="e.src" :alt="e.alt" :title="e.title" @load="imgLoad">
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-shadow-bottom"></div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                items:[],
                width:null,
                height:null,
                proporcion:.9,
                current:0,
                working:false,
                userHover:false
            };
        },
        watch:{
            width(){
                $(this.$refs.riel).width(this.width*this.items.length);
                $(this.$refs.riel).find('.slider-item').width(this.width);
                //$(this.$refs.riel).find('.slider-item').height(this.height);
            },
            height(){
                $(this.$refs.riel).height(this.height);
                $(this.$refs.riel).find('.slider-item').width(this.width);
                //$(this.$refs.riel).find('.slider-item').height(this.height);
            },
            items(){
                $(this.$refs.riel).width(this.width*this.items.length);
            }
        },
        methods:{
            imgLoad(){
                this.height=$(this.$refs.container).height()>0?$(this.$refs.container).height():375;
            },
            right(){
                if(this.current<this.items.length-1&&!this.working){
                    this.working=true;
                    $(this.$refs.container).find('.current').animate({
                        left:'0%'
                    });
                    $(this.$refs.container).find('.current').next().animate({
                        left:'0%'
                    });
                    $(this.$refs.container).find('.current').find('.slider-item-wrapper').animate({
                            height:'70%',
                            padding:'5% 0'
                    });
                    $(this.$refs.container).find('.current').next().find('.slider-item-wrapper').animate({
                            height:'90%',
                            padding:'5% 0'
                    });
                    $(this.$refs.container).find('.current').find('.img').animate({
                        'box-shadow':'0px 0px 0px #000'
                    });
                    $(this.$refs.container).find('.current').next().find('.img').animate({
                        'box-shadow':'3px 3px 10px #000'
                    });
                        this.current++;
                    $(this.$refs.container).animate({
                        scrollLeft:(this.current)*this.width
                    },()=>{
                        this.working=false;
                    });
                }else if(!this.working){
                    this.working=true;
                    $(this.$refs.container).animate({
                        scrollLeft:0
                    },()=>{
                        this.current=0;
                        this.working=false;
                    });
                }
            },
            left(){
                if(this.current>0&&!this.working){
                    this.working=true;
                    $(this.$refs.container).find('.current').animate({
                        left:'-5%'
                    });
                    $(this.$refs.container).find('.current').prev().animate({
                        left:'0%'
                    });
                    $(this.$refs.container).find('.current').find('.slider-item-wrapper').animate({
                            height:'70%',
                            padding:'5% 0'
                    });
                    $(this.$refs.container).find('.current').prev().find('.slider-item-wrapper').animate({
                            height:'90%',
                            padding:'5% 0'
                    });
                    $(this.$refs.container).find('.current').find('.img').animate({
                        'box-shadow':'0px 0px 0px #000'
                    });
                    $(this.$refs.container).find('.current').prev().find('.img').animate({
                        'box-shadow':'3px 3px 10px #000'
                    });
                    $(this.$refs.container).animate({
                        scrollLeft:$(this.$refs.container).scrollLeft()-this.width
                    },()=>{
                        this.current--;
                        this.working=false;
                    });
                }
            }
        },
        mounted() {
            for( let i in this.$slots.default){
                if(this.$slots.default[i].tag){
                    this.items.push({
                        src:this.$slots.default[i].data.attrs.src,
                        title:this.$slots.default[i].data.attrs.title,
                        alt:this.$slots.default[i].data.attrs.alt,
                    });
                }
            }
            this.width=$(this.$refs.container).width();
            setInterval(()=>{
                if(!this.userHover){
                    this.right();
                }
            },5000);
        }
    }
</script>

<style scoped>
    .slider-container{
        width:100%;
        min-width:300px;
        min-height:200px;
        max-height:450px;
        display:block;
        overflow: hidden;
        text-align:center;
        border:2px solid #efecb6;
        box-shadow:0 0 25px #efecb6;
        background:rgba(255,255,255,0.2);
    }
    .slider-shadow-top{
        width:100%;
        height:0px;
        box-shadow: 0 0 74px 30px #fff;
        position: relative;
        z-index:10;
    }
    .slider-shadow-bottom{
        width:100%;
        height:0px;
        box-shadow: 0 0 74px 30px #fff;
        position: relative;
        z-index:10;
    }
    .slider-item{
        position:relative;
        display:inline-block;
    }
    .slider-item.siguiente{
        left:-5%;
    }
    .slider-item.anterior{
        left:5%;
    }
    .slider-item.current{
        left:0;
    }
    .slider-item .slider-item-wrapper{
        height:70%;
        padding:5% 0;
    }
    .slider-item.current .slider-item-wrapper{
        height:90%;
        padding:5% 0;
    }
    .slider-item img{
        height:auto;
        width:50%;
        display:inline;
        transition:0.5s all;
    }
    .slider-item.current img{
        position:relative;
        width:75%;
        box-shadow:3px 3px 10px #000;
        z-index:20;
    }
    .right{
        padding: 126px 0;
        float: right;
        font-size: 62px;
        position: relative;
        z-index: 100;
        margin: 0px -22px -85%;
        cursor: pointer;
        opacity:.8;
    }
    .left{
        padding: 126px 0;
        float: left;
        font-size: 62px;
        position: relative;
        z-index: 100;
        margin: 0px -15px -85%;
        cursor: pointer;
        opacity:.8;
    }
    .left:hover,
    .right:hover{
        opacity:1;
    }
    .left:active,
    .right:active{
        opacity:.8;
    }


@media only screen and (max-width: 600px) {
    .slider-container{
        max-height:250px;
    }
    .slider-item img{
        width:100%;
    }
    .slider-item.current img{
        width:100%;
    }
}
</style>
