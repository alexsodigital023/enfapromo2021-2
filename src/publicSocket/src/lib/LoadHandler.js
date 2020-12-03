const fs = require('fs');

module.exports = {
    loadHandler(name){
        return new Promise((resolve,reject)=>{
          const path=`${__dirname}/handlers/${name}`;
            fs.stat(`${path}.js`,(err,stat)=>{
                if(err){
                    reject('No existe manejador');
                }else{
                    resolve(require(path));
                }
            });
        });
    }
}