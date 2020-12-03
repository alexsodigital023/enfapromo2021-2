<template>
    <div class="col marco3  marco-sociales">
        <div class="marco3-content">
            <ul>
                <li>
                    <a :href="whatsapp" target="_blank"><img alt="whatsapp" src="https://a.wayin.com/images/5365/4a7db5cb-b312-48ad-87c7-bb126fef06f7/logoWhats.png"></a>
                </li>
                <li>
                    <a :href="srcInstagram" download="FotoNutrisuenos.jpg" target="_blank"><img alt="instagram" src="https://a.wayin.com/images/5365/4a7db5cb-b312-48ad-87c7-bb126fef06f7/descarga.png"></a>
                </li>
                <li>
                    <a :href="facebook" target="_blank"><img alt="facebook" src="https://a.wayin.com/images/5365/4a7db5cb-b312-48ad-87c7-bb126fef06f7/logoFace.png"></a>
                </li>
            </ul>
        </div>
    </div>

</template>

<script>
    import Cookies from 'js-cookie';
    export default {
        props:{
            src:null
        },
        watch:{
            src(){
                this.whatsapp=this.whatsapp.replace('TEXT',encodeURI(`Con Nutrisuenos Cal-C-Tose® estoy apoyando a nutrir miles de sueños de los niños del Comedor Santa María. ¡Tú también apoya en www.calctose.com.mx! ${this.src}`));
                this.facebook=this.facebook.replace('URL',encodeURI(`${this.src}`)).replace('TEXT',encodeURI(`Con Nutrisuenos Cal-C-Tose® estoy apoyando a nutrir miles de sueños de los niños del Comedor Santa María. ¡Tú también apoya en www.calctose.com.mx!`));

                const image = new Image();
                image.crossOrigin = "anonymous";
                image.onload = ()=>{
                    const canvas = document.createElement('canvas');
                    canvas.width=image.naturalWidth;
                    canvas.height=image.naturalHeight;
                    canvas.getContext('2d').drawImage(image, 0, 0);
                    const blob =canvas.toDataURL("image/jpeg");
                    this.srcInstagram=canvas.toDataURL("image/jpeg");
                }
                image.src = this.src;
                const tid=localStorage.getItem('tid');
                if(tid){
                    $.ajax({
                        url: 'https://dev-sodigital.mx:5553/ticket',
                        dataType: 'json',
                        type: 'post',
                        contentType: 'application/json',
                        data: JSON.stringify( {
                            tid:tid,
                            foto:this.src
                        } ),
                        processData: false
                    });
                }
            }
        },
        methods:{
            shareFB(){
                this.$emit('fbshare',this.facebook);
            },
            shareInsta(){
            }
        },
        data(){
            return {
                whatsapp:'whatsapp://send?text=TEXT',
                facebook:'https://www.facebook.com/dialog/share?app_id=221983919233812&display=iframe&display=popup&href=URL&quote=TEXT&hashtag=Nutrisuenos',
                srcInstagram:null
            }
        },
        mounted() {
        }
    }
</script>
