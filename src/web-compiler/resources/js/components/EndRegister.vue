<template>
    <div class="end register">
        
    </div>
</template>

<script>
    export default {
        mounted() {
            let time=localStorage.getItem('game_t');
            let moves=localStorage.getItem('game_m');
            let tid=localStorage.getItem('ticket_id');

            jQuery.ajax({
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json' 
                },
                'type': 'POST',
                'url': "https://chocomilk.proxy.beeceptor.com/appv1/ticket",
                'data': JSON.stringify({
                        game_t:time,
                        game_m:moves,
                        tid:tid,

                    }),
                'dataType': 'json'
                });
        }
    }
</script>
