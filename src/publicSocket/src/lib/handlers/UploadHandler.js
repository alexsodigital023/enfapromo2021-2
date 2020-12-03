const fs = require('fs');
const paths = require('../../config/paths.json');
const { v4: uuidv4 } = require('uuid');
const md5File = require('md5-file');
const mariadb = require('mariadb');
const mmm = require('mmmagic');


const magic = new mmm.Magic(mmm.MAGIC_MIME_TYPE);
const pool = mariadb.createPool(require('../../config/database.json'));

module.exports={
    requireAuth:true,
    run(data,user){
        return new Promise((resolve,reject)=>{
            const filename=uuidv4();
            const path=paths.uploads+filename;
            fs.writeFile(path, data,'binary',(err)=>{
                if(err){
                    reject({
                        code:400,
                        message:'No se pudo guardar'
                    });
                }else{
                fs.stat(path,(err,stat)=>{
                    if(err){
                        fs.unlinkSync(path);
                        reject({
                            code:500,
                            message:'No se pudo guardar..'
                        });
                    }else{
                        magic.detectFile(path,(err,mime)=>{
                            if(!(/image\/.*/i).test(mime)&&!(/application\/pdf/i).test(mime)){
                                fs.unlinkSync(path);
                                reject({
                                    code:400,
                                    message:'Formato de archivo no permitido'
                                });
                            }else{
                                md5File(path).then((hash) => {
                                    pool.getConnection()
                                    .then(conn => {
                                        conn.query(`select * from ticket where fingerprint=? and submited=1 limit 1`,[hash]).then(
                                            r=>{
                                                if(r[0]){
                                                    fs.unlinkSync(path);
                                                    reject({
                                                        code:400,
                                                        message:'Archivo duplicado'
                                                    });
                                                }else{
                                                    conn.query(
                                                        `insert into ticket(user_id,estado_id,tienda_id,fingerprint,path,status_id,created_at,updated_at)`+
                                                        `values(?,1,1,?,?,1,now(),now()) on duplicate key update path=?, updated_at=now()`
                                                        ,[user.id,hash,path,path]).then(
                                                            r=>{
                                                                conn.end();
                                                                const id=r.insertId;
                                                                resolve({
                                                                    code:200,
                                                                    data:{
                                                                        type:'statusChange',
                                                                        status:1,
                                                                        tid:id
                                                                    },
                                                                    ticket_id:id
                                                                });
                                                            },error=>{
                                                                conn.end();
                                                                fs.unlinkSync(path);
                                                                console.error(error);
                                                                reject({
                                                                    code:500,
                                                                    message:'No se pudo guardar.'
                                                                });
                                                            }
                                                        );
                                                }
                                            },error=>{
                                                conn.end();
                                                fs.unlinkSync(path);
                                                console.error(error);
                                                reject({
                                                    code:500,
                                                    message:'No se pudo guardar.'
                                                });
                                            }
                                        );
                                    },error=>{
                                        fs.unlinkSync(path);
                                        reject({
                                            code:500,
                                            message:'No se pudo guardar.'
                                        });
                                    });
                                  },error=>{
                                    fs.unlinkSync(path);
                                    reject({
                                        code:400,
                                        message:'No se pudo guardar'
                                    });
                                  });

                            }
                        });

                    }
                });
                }
              });
        })
    },
    removeUpload(id){
        return new Promise((resolve,reject)=>{
            pool.getConnection().then(
                conn=>{
                    conn.query(`select path from ticket where id = ?`,[id]).then(
                        r=>{
                            if(r[0]){
                                fs.unlinkSync(path);
                                conn.query(`delete from ticket where id = ? limit 1`,[id]).then(
                                    r=>{
                                        conn.end();
                                        resolve(r);
                                    },
                                    error=>{
                                        conn.end();
                                        reject(error);
                                    }
                                );
                            }else{
                                conn.end();
                            }
                        },error=>{
                            conn.end();
                            reject(error)
                        }
                    );
                },error=>reject(error)
            );
        });
    }
}