@extends('layout.Main',[
  "menu"=>'faq'
])
@section('title', 'Impulsa su potencial y ¡Gana!')
@section('class', 'faq')
@section('id', 'faq')
@section('state', 'soDigital')
@section('content')

<div class="container-fluid enfa-promo faq">
  <div class="row enfa-container">
    <div class="col-12 text-center">
      <img src="images/logo_enfalogros.png" alt="" class="img-responsive img-fluid center-block logo">
      <h1 class="text-center mb-5">Preguntas frecuentes</h1><div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0 text-left">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          lorem 1
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body text-left">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0 text-left">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          lorem 2
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body text-left">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h5 class="mb-0 text-left">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          lorem 3
        </button>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body text-left">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>
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