<template>
    <li :class="estilo">
        <i class="bullet">{{number}}</i>
        <strong>{{title}}</strong>
        <div class="li-body">
            <slot></slot>
        </div>
    </li>
</template>

<script>
    export default {
        props:{
            number:null,
            estilo:null,
            title:null
        }
    }
</script>
