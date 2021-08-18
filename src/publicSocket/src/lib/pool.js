const mysql = require('mysql2');

module.exports = {
    getConnection:()=>{
        return new Promise((resolve,reject)=>{
            const pool = mysql.createPool(require('../config/database.json'));
            resolve({
                query:(query,data,callback)=>{
                    return new Promise((resolve,reject)=>{
                        pool.query(query,data,(error, results, fields)=>{
                            if (error){
                                reject(error);
                            }else{
                                resolve(results);
                            }
                        });
                    });
                },
                end:()=>{
                    pool.end(()=>{
                        console.log("conexion cerrada");
                    });
                }
            });
        });
    }
}