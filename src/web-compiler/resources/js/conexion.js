import https from 'https';
import http from 'http';
import { v4 as uuidv4 } from 'uuid';

export default class {
    constructor(config){
        this.config=config;
        this.agent = new https.Agent({ keepAlive: true });
        this.callbacks={};
        this.connected=false;
        this.timeout=5000;
        this.timeoutInterval=null;
    }
    open(uuid){
        return new Promise((resolve,reject)=>{
            this.getToken(uuid).then(
                token=>{
                    this.getClient().then(
                        client=>{
                            this.authenticate(token).then(
                                ok=>{
                                    this.conectado=true;
                                    resolve(this.conectado);
                                },
                                error=>reject(error)
                            )
                        },error=>reject(error)
                    );
                },error=>reject(error)
            );
        });
    }
    closeHandler(){
        this.conectado=false;
        if(this.client){
            this.client=null;
        }
    }
    messageHandler(m){
        this.stopTimeout();
        if(m && m.data){
            const d = JSON.parse(m.data);
            if(d&&d.code==200&&d.tx){
                this.resolveCallback(d.tx,d.data);
            }else{
                this.rejectCallback(d.tx,d.data);
            }
        }
    }
    resolveCallback(tx,data){
        if(this.callbacks[tx]){
            this.callbacks[tx].resolve(data);
            if(!this.callbacks[tx].unlimited){
                this.callbacks[tx]=null;
            }
        }else{
            console.error(`Sin callback para la transacción ${tx}`,this.callbacks);
        }
    }
    rejectCallback(tx,data){
        if(this.callbacks[tx]){
            this.callbacks[tx].reject(data);
            if(!this.callbacks[tx].unlimited){
                this.callbacks[tx]=null;
            }
        }else{
            console.error(`Sin reject callback para la transacción ${tx}`);
        }
    }
    getClient(){
        return new Promise((resolve,reject)=>{
            if(this.client){
                resolve(this.client);
            }else{
                var W3CWebSocket = require('websocket').w3cwebsocket;
                var client = new W3CWebSocket(`${this.config.socket.host.protocol}://${this.config.socket.host.host}:${this.config.socket.host.port}${this.config.socket.host.path}`, this.config.socket.protocol);
                client.onerror = (error)=>reject(error);
                client.onopen=()=>{
                    this.client=client;
                    this.client.onclose=()=>this.closeHandler();
                    this.client.onmessage=message=>this.messageHandler(message);
                    resolve(this.client);
                }
            }
        });
    }
    registerCallback(tx,resolve,reject,unlimited){
        this.callbacks[tx]={
            tx:tx,
            resolve:resolve,
            reject:reject,
            unlimited:unlimited
        };
    }
    authenticate(token){
        return new Promise((resolve,reject)=>{
            this.getClient().then(
                client=>{
                    var tx=uuidv4();
                    this.registerCallback(tx,resolve,reject,false);
                    const message={
                        action:'authenticate',
                        tx:tx,
                        data:token
                    };
                    this.initTimeout();
                    client.send(JSON.stringify(message));
                },error=>reject(error)
            );
        });
    }
    registerTimeoutHandler(handler){
        this.onTimeout=handler;
    }
    initTimeout(){
        this.stopTimeout();
        this.timeoutInterval=setTimeout(()=>{
            if(this.client){
                this.client.close();
            }
            if(this.onTimeout){
                this.onTimeout();
            }
            this.timeoutInterval=null;
        },this.timeout);
    }
    stopTimeout(){
        if(this.timeoutInterval){
            clearTimeout(this.timeoutInterval);
            this.timeoutInterval=null;
        }
    }
    send(action,data){
        return new Promise((resolve,reject)=>{
            this.getClient().then(
                client=>{
                    const tx=uuidv4();
                    const message={
                        action:action,
                        data:data,
                        tx:tx
                    };
                    this.registerCallback(tx,ok=>resolve,reject,false);
                    this.initTimeout();
                    client.send(JSON.stringify(message));
                },error=>reject(error)
            );
        });
    }
    sendFile(file,updateCallback){
        return new Promise((resolve,reject)=>{
            this.getClient().then(
                client=>{
                    const tx=uuidv4();
                    const tx2=uuidv4();
                    const message={
                        action:'sendFile',
                        data:tx2,
                        tx:tx
                    };
                    this.registerCallback(tx,ok=>{
                        this.stopTimeout();
                        this.registerCallback(tx2,updateCallback,reject,true);
                        client.send(file);
                    },reject,false);
                    client.send(JSON.stringify(message));
                },error=>reject(error)
            );
        });
    }
    getToken(uuid){
        return new Promise((resolve,reject)=>{
            this.post(this.config.auth.host,{
                email:uuid
            }).then(
                res=>{
                    if(res&&res.token){
                        resolve(res.token);
                    }else{
                        reject("Error desconocido al obtener token");
                    }
                },error=>reject(error)
            );
        });
    }
    post(destino,data,authorization){
        var data = JSON.stringify(data);
        return new Promise((resolve,reject)=>{
            const config = {
              agent: this.agent,
              method: 'POST',
              host: destino.host,
              port: destino.port,
              path: destino.path,
              headers: {
                'Content-Type': 'application/json',
                Accept: '*/*',
                'Content-Length': Buffer.byteLength(data),
              },
            };
            const req = https.request(config, (res) => {
                if (res.statusCode != 200 && res.statusCode != 201) {
                  reject(res);
                }
                res.setEncoding('utf8');
                let response = null;
                res.on('data', (chunk) => {
                  response = JSON.parse(chunk);
                });
                res.on('end', () => {
                  this.access_token = response;
                  resolve(this.access_token);
                });
              });
              req.on('error', (e) => {
                reject(e);
              });
              req.write(data);
              req.end();
        });

    }
}