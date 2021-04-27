<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Nutrisue&ntilde;os | @yield('title')</title>
  <link rel="stylesheet" type="text/css" href="https://s.wayin.com/themes/base2/css/base.min.gz.css?u=1596213612000"
    id="styles-base">

  <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="https://s.wayin.com/themes/base2/css/ie8.min.gz.css?u=1596213612000" id="styles-legacy-base"><![endif]-->
  <link rel="stylesheet" type="text/css"
    href="https://s.wayin.com/themes/scaffold2/css/theme.min.gz.css?u=1596213612000" id="styles-foundation">

  <!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="https://s.wayin.com/themes/scaffold2/css/ie8.min.gz.css?u=1596213612000" id="styles-legacy-foundation"><![endif]-->
  <link rel="stylesheet" type="text/css" href="https://a.wayin.com/themes/5365/165885/theme.min.gz.css?u=1596213803000"
    id="styles-overrides">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/app.css">
</head>

<body
  class="@yield('state')   xModula notEntered xEmbedFixed xFormatWidget has7Pages isPrelaunchPhase noParticipantWall noIncentiveData xCampaignPage xBody xCampaignSweepstake noSponsor noBGImage noFeatureImage noMainImage noCountdown hasForm noWizard "
  data-ngx-tracking="">
  <main class="xPage">
    <div class="xPageInner">
    <header id="xSectionHeader" class="xPageHeader xSection xSectionStatic" role="banner">
		
	<div class="xRow xRow-1col_full n1 odd first" id="HeaderR1">
  <div class="xRowInner">
		
			<div class="xCell n1 first last full" id="HeaderR1C1">
  <div class="xCellInner">
				
					
					<div id="Header_xModule_Header" data-ngx-id="xModule_Header" data-componenttype="campaignheader" style="" class="xComponent xCampaignHeader n1 xFullColModule xTmpl-TitlesBannerNav" data-registered="true">
  <div class="xComponentInner">






    <div class="xNavShareWrapper">
        
			<nav class="xNavigation" role="navigation">
				<ul class="xTabs xNavMain">
  <li class="nav xTab detailsTab inStart">
    <a data-ngx-action="route:details" href="{{route('home')}}" class="xTabLink">
      <span class="xTabInner">Participa</span>
    </a>
  </li>
  <li class="nav xTab prizesTab inStart">
    <a data-ngx-action="route:prizes" href="{{route('semanales')}}" class="xTabLink">
      <span class="xTabInner">Premios Semanales</span>
    </a>
  </li>
  <li class="nav xTab content1Tab inStart">
    <a data-ngx-action="route:content1" href="{{route('diarios')}}" class="xTabLink">
      <span class="xTabInner">Premios Diarios</span>
    </a>
  </li>
  <li class="nav xTab contentTab inStart">
    <a data-ngx-action="route:content" href="{{route('contacto')}}" class="xTabLink">
      <span class="xTabInner">Contacto</span>
    </a>
  </li>
  <li class="nav xTab content2Tab inStart">
    <a data-ngx-action="route:content2" href="{{route('faq')}}" class="xTabLink">
      <span class="xTabInner">Preguntas Frecuentes</span>
    </a>
  </li>
  <li class="nav xTab content3Tab inStart">
    <a data-ngx-action="route:content3" href="{{route('privacidad')}}" class="xTabLink">
      <span class="xTabInner">Aviso de Privacidad</span>
    </a>
  </li>
  <li class="nav xTab content4Tab inStart">
    <a data-ngx-action="route:content4" href="{{route('tyc')}}" class="xTabLink current">
      <span class="xTabInner">Términos y Condiciones</span>
    </a>
  </li>
</ul>
				
			</nav>
		
		
			
		
	</div>




</div>
</div>
					
				 
			</div>
</div>
		 
	</div>
</div>


	</header>
  <main role="main" class="xPageMain">
                        
                            
                  
      <section id='@yield("id")' class="xSection @yield('class') xSectionContent" data-stateName="@yield(' class')"
        data-ngx-id='598109'>
          @yield("content")
      </section>              
  
                                
                            
                        	
                    </main>
    </div>
  </main>
  <script src="js/app.js"></script>
</body>

</html>