@extends('layout.Main',[
  "menu"=>'home'
])
@section('title', 'Impulsa su potencial y ¡Gana!')
@section('class', 'home')
@section('id', 'home')
@section('state', 'soDigital')
@section('content')

<div class="container-fluid enfa-promo">
  <div class="row enfa-container">
    <div class="shopping-cart">
      <div class="shop">
        <p>Compra aquí</p>
      </div>
      <div class="store amazon"><a href=""><img src="images/amazon.png" alt=""></a></div>
      <div class="store sams"><a href=""><img src="images/sams.png" alt=""></a></div>
    </div>

    <div class="col-12 text-center title">
      <h1 class="title"><strong>¡Los logros de tu bebé</strong> te harán ganar hasta</h1>
      <img src="images/premio.jpeg" alt="" class="img-responsive img-fluid">
      <p class="subtitle">más miles de premios diarios!</p>

      <div class="row pasos">
        <div class="col col-md-4">
          <p><img src="images/uno.jpeg" alt="" class="img-responsive img-fluid"><strong>Compra</strong></p>
        </div>
        <div class="col col-md-4">
          <p><img src="images/dos.jpeg" alt="" class="img-responsive img-fluid"><strong>Registra</strong></p>
        </div>
        <div class="col col-md-4">
          <p><img src="images/tres.jpeg" alt="" class="img-responsive img-fluid"><strong>Gana un premio al instante</strong></p>
        </div>
        <div class="col">
          <p><img src="images/tres.jpeg" alt="" class="img-responsive img-fluid"><strong>Comparte un video de 30 seg en tu Facebook®* personal con los logros de tu bebé usando #EnfaLogros. El que tenga más likes, gana.</strong></p>
        </div>
      </div>

      <h2 class="subtitle-h2">¡Estás a nada de ganar!</h2>
      <h3 class="subtitle-h3">Regístrate</h3>
    </div>
    <div class="col-md-6">
      <form>
        <small>Los campos con * son obligatorios</small>
        <div class="form-group">
          <label for="inputNombre">*Nombre</label>
          <input type="text" id="inputNombre" class="form-control">
        </div>
        <div class="form-group">
          <label for="inputApellido">*Apellido</label>
          <input type="text" id="inputApellido" class="form-control">
        </div>
        <div class="form-group">
          <label for="inputCorreo">*Correo electrónico</label>
          <input type="email" id="inputCorreo" class="form-control">
        </div>
        <div class="form-group">
          <label for="inputNacimiento">*Fecha de nacimiento del bebé</label>
          <input type="datetime" id="inputNacimiento" class="form-control">
        </div>
        <div class="form-group">
          <label for="inputMonto">*Monto de compra productos Enfagrow</label>
          <input type="text" id="inputMonto" class="form-control">
        </div>
        <p class="text-center sube">SUBE la foto de tu ticket aquí</p>
        <div class="form-group file">
          <label for="inputFile" class="file btn">Buscar imagen</label>
          <input type="file" id="inputFile" class="file">
        </div>
        <div class="captcha">
          <div class="btn captcha-btn" id="captcha">Captcha</div>
        </div>
        <div class="checkbox">
          <label class="checkbox">
            <input type="checkbox"> He leído y acepto los <a href="/terminos-y-condiciones" target="_blank"><i>términos y condiciones</i></a>
          </label>
          <label class="checkbox">
            <input type="checkbox"> He leído y acepto el <a href="/aviso-de-privacidad" target="_blank"><i>aviso de privacidad</i></a>
          </label>
          <label class="checkbox">
            <input type="checkbox"> Soy mayor de edad
          </label>
        </div>
        <button type="submit" class="btn">Envia tus datos y participa</button>
      </form>
    </div>
    <div class="col-md-6">
      <img src="images/bebe_promo.png" alt="" class="img-responsive img-fluid bebe">
    </div>

    <div class="col-12 text-center footer">
      <small class="video">*El subir el video no es requisito obligatorio para ganar.</small>
      <small>Enfagrow® puede formar parte de la dieta correcta de niños mayores de 1 año de edad. Consulta las bases, términos y condisiones en: EnfaRewards.com</small>

      <div class="row legales">
        <div class="col col-md-4">
          <small>Vigencia del 1 de septiembre al 31 de octubre de 2021</small>
        </div>
        <div class="col col-md-4">
          <p>ALIMÉNTALO SANAMENTE</p> 
        </div>
        <div class="col col-md-4">
          <small><a href="http://www.enfabebe.com.mx/enfa-logros">www.enfabebe.com.mx/enfa-logros</a></small>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection('content')