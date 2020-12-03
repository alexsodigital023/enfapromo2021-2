<template>
    <div :class="cssClass">
        <a :href="link">
            <img :src="image" alt="Cal-C-Tose">
        </a>
    </div>
</template>

<script>
    export default {
        props:{
            cssClass:null,
            image:null,
            link:null
        }
    }
</script>
