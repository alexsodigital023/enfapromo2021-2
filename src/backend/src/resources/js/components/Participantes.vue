<template>

    <table class="table table-bordered table-responsive w-100 d-block d-md-table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th colspan="3"></th>
                <th colspan="5" class="text-center">Tickets</th>
                <th></th>
            </tr>
            <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Total</th>
            <th>Aprobados</th>
            <th>Rechazados</th>
            <th>Nuevos</th>
            <th>Premiados</th>
            <th>Activo</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            <tr  v-for="u in users" class="form-group">
                <td>{{u.id}}</td>
                <td>{{u.name}}</td>
                <td>
                    <a :href="`mailto:${u.email}`" target="_blank">
                        <i class="fa fa-envelope"></i>
                        {{u.email}}
                    </a>
                </td>
                <td class="text-right">{{u.tickets}}</td>
                <td class="text-right">{{u.aprobados}}</td>
                <td class="text-right">{{u.rechazados}}</td>
                <td class="text-right">{{u.nuevos}}</td>
                <td class="text-right">{{u.premiados}}</td>
                <td><toggle-button :value="u.activo" @change="(a)=>{changeSwitch('activo',a.value,u)}"/></td>
                <td>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props:{
        },
        data(){
            return {
                showModal:null,
                users:[]
            };
        },
        watch:{
        },
        methods:{
            changeProfile(profile_id,user){
                console.log(user.updateLink);
                $.post(user.updateLink,{
                    profile_id:profile_id
                },()=>{
                    user.profile_id=profile_id;
                });
            },
            update(name,event,user){
                $(event.target).addClass("bg-warning");
                const c={};
                c[name]=event.target.value;
                $.post(user.updateLink,c,()=>{
                    $(event.target).removeClass("bg-warning");
                    user[name]=event.target.value;
                });
            },
            changeSwitch(name,value,user){
                const c={};
                c[name]=value?1:0;
                $.post(user.updateLink,c,()=>{
                    user[name]=value;
                });
            }
        },
        mounted() {
            for(var i in this.$slots.default){
                if(this.$slots.default[i].data){
                    this.users.push({
                        id:this.$slots.default[i].data.attrs.id,
                        name:this.$slots.default[i].data.attrs.name,
                        profile:this.$slots.default[i].data.attrs.profile,
                        profile_id:this.$slots.default[i].data.attrs.profile_id,
                        email:this.$slots.default[i].data.attrs.email,
                        oauth:this.$slots.default[i].data.attrs.oauth>0?true:false,
                        activo:this.$slots.default[i].data.attrs.activo>0?true:false,
                        backend:this.$slots.default[i].data.attrs.backend>0?true:false,
                        updateLink:this.$slots.default[i].data.attrs.update,
                        tickets:this.$slots.default[i].data.attrs.tickets,
                        aprobados:this.$slots.default[i].data.attrs.aprobados,
                        rechazados:this.$slots.default[i].data.attrs.rechazados,
                        nuevos:this.$slots.default[i].data.attrs.nuevos,
                        premiados:this.$slots.default[i].data.attrs.premiados
                    });
                }
            }
        }
    }
</script>
<style scoped>
</style>