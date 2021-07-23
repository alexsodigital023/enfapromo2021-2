@extends('layout.Main',[
  "menu"=>'home'
])
@section('title', 'Impulsa su potencial y ¡Gana!')
@section('class', 'home')
@section('id', 'home')
@section('state', 'soDigital')
@section('content')

<div class="container-fluid promo">
  <div class="row">
    <div class="col-12 text-center title">
      <h1 class="tit"><strong>¡Los logros de tu bebé</strong> te harán ganar hasta</h1>
      <img src="https://via.placeholder.com/1200x80" alt="" class="img-responsive img-fluid">
      <p class="tit">más miles de premios diarios!</p>

      <h2 class="sub">¡Estás a nada de ganar!</h2>
      <h3>Regístrate</h3>
    </div>
    <div class="col-md-6">
      <small>Los campos con * son obligatorios</small>
      <form>
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
        <p class="text-center">SUBE la foto de tu ticket aquí</p>
        <div class="form-group file">
          <label for="inputFile">Buscar imagen</label>
          <input type="file" id="inputFile">
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox"> He leído y acepto los términos y condiciones
          </label>
          <label>
            <input type="checkbox"> He leído y acepto el aviso de privacidad
          </label>
          <label>
            <input type="checkbox"> Soy mayor de edad
          </label>
        </div>
        <button type="submit" class="btn btn-primary">Envia tus datos y participa</button>
      </form>
    </div>
    <div class="col-md-6">
      <img src="https://via.placeholder.com/650x800" alt="" class="img-responsive img-fluid">
    </div>
    <div class="col-12 text-center footer">
      <small class="video">*El subir el video no es requisito obligatorio para ganar.</small>
      <small>Enfagrow® puede formar parte de la dieta correcta de niños mayores de 1 año de edad. Consulta las bases, términos y condisiones en: EnfaRewards.com</small>
      <small>Vigencia del 1 de septiembre al 31 de octubre de 2021</small> <p>ALIMÉNTALO SANAMENTE</p> <small><a href="http://www.enfabebe.com.mx/enfa-logros">www.enfabebe.com.mx/enfa-logros</a></small>
    </div>
  </div>
</div>


@endsection('content')