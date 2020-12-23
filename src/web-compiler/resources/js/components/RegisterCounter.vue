<template>
    <div class="registros card">
        <div class="card-title">Registros</div>
        <div class="card-body">{{total}}</div>
    </div>
</template>

<script>
import https from 'https';
export default {
    props:{
        length:{
            type:[String, Number],
            default:5
        }
    },
    data(){
        return {
            total: 0
        }
    },
    mounted() {
        $.get("http://localhost:8085/ticket",(r)=>{
            this.total=(r.total_items).toString().padStart(this.length,"0");
        })
    }
}
</script>
