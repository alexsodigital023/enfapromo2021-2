
const pool = require('../pool');

module.exports={
    requireAuth:false,
    run(token){
        return new Promise((resolve,reject)=>{
            pool.getConnection()
                .then(conn => {
                  conn.query(`select users.id from oauth_access_tokens left join users on users.email = oauth_access_tokens.user_id where access_token=? and expires>now() limit 1`,[
                      token
                  ]).then(
                    r=>{
                        if(!r[0]){
                            reject({
                                code:404,
                                message:'Error de autenticación'
                            });
                        }else{
                            resolve({
                                code:200,
                                data:'Autentificado',
                                disconect:false,
                                user:r[0]
                            });
                        }
                        conn.end();
                    },
                    error=>{
                        conn.end();
                        reject({
                            code:400,
                            message:'Error de autenticación'
                        })}
                  );
                },err=>console.error(err));
        });
    }
}