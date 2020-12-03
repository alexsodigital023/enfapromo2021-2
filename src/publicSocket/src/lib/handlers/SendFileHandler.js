module.exports={
    requireAuth:true,
    run(data,user){
        return new Promise((resolve,reject)=>{
            resolve({
                code:200,
                data:'Inicie envío ahora',
                disconect:false,
                init_file_transfer:true,
                file_tx:data
            });
        });
    }
}