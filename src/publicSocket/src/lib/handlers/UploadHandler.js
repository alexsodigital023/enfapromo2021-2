const paths = require('../../config/paths.json');
const s3Credentials = require('../../config/s3.json');
const { v4: uuidv4 } = require('uuid');
const https = require('https');
const md5 = require('md5');
const mmm = require('mmmagic');
const AWS = require('aws-sdk');


const magic = new mmm.Magic(mmm.MAGIC_MIME_TYPE);
const ep = new AWS.Endpoint(s3Credentials.endpoint);
const pool = require('../pool');

const s3 = new AWS.S3({
    accessKeyId: s3Credentials.accessKeyId,
    secretAccessKey: s3Credentials.secretAccessKey,
    endpoint: ep
  });

module.exports={
    requireAuth:true,
    run(data,user){
        return new Promise((resolve,reject)=>{
            const filename=uuidv4();
            const path=`${paths.uploads}/${filename}`;

            let hash=md5(data);
            pool.getConnection()
                .then(conn => {
                    conn.query(`select * from ticket where fingerprint=? and submited=1 limit 1`,[hash]).then(
                        r=>{
                            if(r[0]){
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
                                            const params = {
                                                Bucket: 'chocomilk',
                                                Key: path,
                                                Body: data
                                            };
                                            s3.upload(params,(s3Err, data)=>{
                                                if(s3Err){
                                                    reject({
                                                        code:400,
                                                        message:'No se pudo guardar'
                                                    });
                                                }else{
                                                    console.log("ejecutando servicio",`${paths.ocr}?id=${id}`);
                                                    https.get(`${paths.ocr}?id=${id}`, (res) => {

                                                        let response = null;
                                                        res.on('data', (d) => {
                                                            console.log("recibido",d);
                                                            try{
                                                                response = JSON.parse(d);
                                                                resolve({
                                                                    code:200,
                                                                    data:{
                                                                        type:'statusChange',
                                                                        status:response.status_id,
                                                                        import:response.import,
                                                                        tid:id
                                                                    },
                                                                    ticket_id:id
                                                                });
                                                            }catch(e){
                                                                reject({
                                                                    code:500,
                                                                    message:'No se pudo analizar.'
                                                                });
                                                            }
                                                        });

                                                        }).on('error', (e) => {
                                                            reject({
                                                                code:500,
                                                                message:'No se pudo analizar.'
                                                            });
                                                    
                                                        resolve({
                                                            code:200,
                                                            data:{
                                                                type:'statusChange',
                                                                status:8,
                                                                tid:id
                                                            },
                                                            ticket_id:id
                                                        });
                                                    });
                                                }
                                            });
                                        },error=>{
                                            conn.end();
                                            reject({
                                                code:500,
                                                message:'No se pudo guardar.'
                                            });
                                        }
                                    );
                            }
                        },error=>{
                            conn.end();
                            reject({
                                code:500,
                                message:'No se pudo guardar.'
                            });
                        });
                },error=>{
                    reject({
                        code:500,
                        message:'No se pudo guardar.'
                    });
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