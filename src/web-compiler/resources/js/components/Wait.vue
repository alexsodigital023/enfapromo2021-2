<template>
    <div class="waitFrame">
        <div class="waitframe-inner">
            <div class="percent">{{percent}}</div>
            <div :class="`glass status_${status}`">
            </div>
            <div class="message">
                {{message}}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            percent:null,
            message:null,
            status:null
        }
    }
</script>

<style scoped>
    .waitFrame{
        position:fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        z-index:1000;
        text-align:center;
    }
    .waitframe-inner{
        display:inline-block;
        width:50%;
        height:50%;
        margin-top:5%;
    }

@media only screen and (max-width: 1100px) {
    .waitframe-inner{
        margin:0;
    }
}
@media only screen and (max-width: 600px) {
    .waitframe-inner{
        margin:0;
        width:100% !important;
    }
}
</style>