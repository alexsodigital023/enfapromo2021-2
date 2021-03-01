<template>

    <table class="table table-bordered table-responsive w-100 d-block d-md-table" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Perfil</th>
            <th>Email</th>
            <th>Aplicación</th>
            <th>Activo</th>
            <th>Backend</th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            <tr  v-for="u in users" :key="u.id" class="form-group">
                <td>{{u.id}}</td>
                <td><input type="text" :value="u.name" class="form-control" @change="(event)=>update('name',event,u)"></td>
                <td><profile-selector :profiles="profiles" :value="u.profile_id" v-on:change="(val)=>{changeProfile(val,u)}"></profile-selector></td>
                <td><input type="email" :value="u.email" class="form-control" @change="(event)=>update('email',event,u)"></td>
                <td><toggle-button :value="u.oauth"  @change="(a)=>{changeSwitch('oauth',a.value,u)}"/></td>
                <td><toggle-button :value="u.activo" @change="(a)=>{changeSwitch('activo',a.value,u)}"/></td>
                <td><toggle-button :value="u.backend" @change="(a)=>{changeSwitch('backend',a.value,u)}"/></td>
                <td>
                    <button class="btn btn-warning" title="Cambiar contraseña" @click="()=>cambiarContra(u.id)"><i class="fa fa-key"></i></button>
                    <div v-if="showContra==u.id" class="passwordChange form-group">
                        <input type="password" class="form-control" placeholder="Nueva Contraseña" :ref="`pass_${u.id}`">
                        <button class="btn btn-info" @click="()=>cambiarPassword(u)"><i class="fa fa-save"></i> Cambiar</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props:{
            profilesRaw:null
        },
        data(){
            return {
                showModal:null,
                showContra:false,
                users:[],
                profiles:[]
            };
        },
        watch:{
        },
        methods:{
            cambiarContra(id){
                this.showContra=this.showContra==id?null:id;
            },
            changeProfile(profile_id,user){
                console.log(user.updateLink);
                $.post(user.updateLink,{
                    profile_id:profile_id
                },()=>{
                    user.profile_id=profile_id;
                });
            },
            cambiarPassword(user){
                const val=this.$refs[`pass_${user.id}`]&&this.$refs[`pass_${user.id}`][0]?this.$refs[`pass_${user.id}`][0].value:null;
                if(val){
                    this.showContra=null;
                    $.post(user.updateLink,{
                        'password':val
                    },()=>{
                    });
                }
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
                        updateLink:this.$slots.default[i].data.attrs.update
                    });
                }
            }
            let profiles=JSON.parse(this.profilesRaw);
            for(var i in profiles){
                if(profiles[i]&&profiles[i].id){
                    this.profiles.push(profiles[i]);
                }
            }
        }
    }
</script>
<style scoped>
</style>