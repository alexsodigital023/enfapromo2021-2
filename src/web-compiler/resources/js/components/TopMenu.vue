<template>
    <div :class="cssClass">
        <nav>
            <ul>
                <li>
                    <slot></slot>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props:{
            cssClass:null,
            current:null
        },
        data(){
            return {
                tamano:null
            }
        },
        methods:{
            resize(){
                console.log('wiiii');
            },
            makeBig(){
                console.log("grande");

            },
            makeSmall(){
                console.log("pequeño");
            }
        },
        created() {
            $(window).bind('resize',()=>{
                this.resize();
            })
        },
        mounted() {
                this.resize();
        },
    }
</script>
