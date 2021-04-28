const websocket = require('ws');
const http = require('http');
const fs = require('fs');
const express = require('express');
const handleLoader = require('./lib/LoadHandler');
const TicketWatcher = require('./lib/watchers/TicketWatcher');
const mmm = require('mmmagic');


const magic = new mmm.Magic(mmm.MAGIC_MIME_TYPE);

const app = express();


const server = http.createServer(app);

const wss = new websocket.Server({ server });

app.on('upgrade', wss.handleUpgrade);
wss.on('connection', ws => {
  console.log("conectado");
  var user;
  var tw;
  ws.on('message', function incoming(data) {
    switch(typeof(data)){
      case 'string':
        console.log("mensaje recibido",data);
        try{
          const d=JSON.parse(data);
          let action=d.action;
          if(!action){
            throw 'Se requiere un action';
          }
          action=action.charAt(0).toUpperCase() + action.slice(1);
          handleLoader.loadHandler(`${action}Handler`).then(
            handler=>{
              console.log(user);
              handler.run(d.data,user).then(
                (res)=>{
                  ws.send(JSON.stringify({
                    code:res.code,
                    data: res.data,
                    tx:d.tx
                  }));
                  if(res.user){
                    user=res.user;
                  }
                  if(res.init_file_transfer){
                    user.file_tx=res.file_tx;
                  }
                  if(res.close){
                    ws.close();
                  }
                },(e)=>{
                  ws.send(JSON.stringify({
                    code:e.code,
                    message: e.message,
                    tx:d.tx
                  }));
                  ws.close();
                }
              )
            },error=>{
              ws.send(JSON.stringify({
                code:500,
                message: 'No existe manejador para ese action',
                tx:d.tx
              }));
              ws.close();
            }
          );
        }catch(e){
          ws.send(JSON.stringify({
            code:500,
            message: e,
            tx:d.tx
          }));
          ws.close();
        }
        break;
      case 'object':
        handleLoader.loadHandler('UploadHandler').then(
          handler=>{
            console.log(user);
            if(handler.requireAuth&&!user){
              ws.send(JSON.stringify({
                code:404,
                message: 'Usuario no autentificado',
                tx:null
              }));
              ws.close();
            }else{
              if(!user.file_tx){
                ws.send(JSON.stringify({
                  code:400,
                  message: 'No se puede enviar archivo ahora',
                  tx:null
                }));
                ws.close();
              }else{
                if(user.ticket_id){
                  handler.removeUpload(user.ticket_id).then(
                    ()=>user.ticket_id=null,
                    e=>console.error(e)
                  );
                }
                handler.run(data,user).then(
                  (res)=>{
                    if(!tw){
                      tw=new TicketWatcher();
                    }
                    tw.watchTicket(res.ticket_id,user.file_tx,(r)=>{
                      ws.send(JSON.stringify({
                        code:r.code,
                        data: r.data,
                        tx:r.file_tx
                      }));
                    });
                    user.ticket_id=res.ticket_id;
                    ws.send(JSON.stringify({
                      code:res.code,
                      data: res.data,
                      tx:user.file_tx
                    }));
                    user.file_tx=null;
                  },(e)=>{
                    ws.send(JSON.stringify({
                      code:e.code,
                      message: e.message,
                      tx:user.file_tx
                    }));
                    user.file_tx=null;
                    ws.close();
                  }
                );
              }
            }
          },e=>{
              ws.send(JSON.stringify({
                code:e.code,
                message: e.message,
                tx:d.tx
              }));
              ws.close();
            }
        );
        break;
    }
  });
},error=>console.error("Error al conectar",error));

server.listen(3000, () => {
    console.log('server started on PORT 3000');
});
