
const pool = require('../pool');
const https = require('https');

const acl={
    'numero':true,
    'email':true,
    'nombre':true,
    'telefono':true,
    'apellido':true,
    'edad':true,
    'ciudad':true,
    'tienda':true,
    'foto':true,
    'estado_id':true,
    'tienda_id':true,
    'mes':true,
    'dia':true,
    'anyo':true,
    'game_t':true,
    'game_m':true
}

module.exports={
    requireAuth:true,
    run(data,user){
        return new Promise((resolve,reject)=>{
            if(!acl[data.name]){
                reject({
                    code:403,
                    message:'No permitido'
                });
            }else{
                if(!user.ticket_id){
                    reject({
                        code:404,
                        message:'no hay ticket'
                    });
                }else{
                    pool.getConnection().then(
                        conn=>{
                            conn.query(`update ticket set ${data.name} = ? where id = ? limit 1`,[
                                data.value,
                                user.ticket_id
                            ]).then(
                                r=>{
                                    conn.end();
                                    if(data.name=='apellido'){
                                        https.get(`${paths.report}?id=${user.ticket_id}`);
                                    }
                                    resolve({
                                        code:200,
                                        data:'actualizado'
                                    });
                                },error=>{
                                    conn.end();
                                    reject({
                                        code:400,
                                        message:'No se pudo actualizar'
                                    })
                                }
                            );
                        },e=>reject({
                            code:400,
                            message:'No se pudo actualizar'
                        })
                    );
                }
            }
        });
    }
}