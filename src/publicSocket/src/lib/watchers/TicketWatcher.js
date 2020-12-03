const mariadb = require('mariadb');
const pool = mariadb.createPool(require('../../config/database.json'));

module.exports = class {
    constructor(){
        this.observers=[];
        this.interval=null;
        this.last=null;
    }
    watchTicket(id,tx,callback){
        pool.getConnection().then(conn => {
            this.interval=setInterval(()=>{
                conn.query(`select status_id from ticket where id = ? limit 1`,[id]).then(
                    r=>{
                        if(r[0]){
                            if(!this.last){
                                this.last=r[0].status_id;
                            }else if(this.last!=r[0].status_id){
                                this.last=r[0].status_id;
                                callback({
                                    code:200,
                                    data:{
                                        type:'statusChange',
                                        status:r[0].status_id
                                    },
                                    file_tx:tx,
                                });

                            }
                            if(r[0].status_id==2||r[0].status_id==3){
                                clearInterval(this.interval);
                                conn.end();
                            }
                        }else{
                            clearInterval(this.interval);
                            conn.end();
                        }
                    },error=>{
                        clearInterval(this.interval);
                        console.error(error);
                        conn.end();
                    }
                );
            },1000)
        },error=>console.error(error)
        );
    }
}