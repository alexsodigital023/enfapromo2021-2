<template>
    <li :class="estilo">
        <i class="bullet">{{number}}</i>
        <div class="body">
            <div class="top"></div>
            <div class="content">
                <slot></slot>
            </div>
            <div class="bottom"></div>
        </div>
        <i class="tail"></i>
    </li>
</template>

<script>
    export default {
        props:{
            number:null,
            estilo:null
        }
    }
</script>
