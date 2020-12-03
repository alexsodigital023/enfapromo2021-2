<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Nutrisue&ntilde;os | @yield('title')</title>
        <link rel="stylesheet" type="text/css" href="https://s.wayin.com/themes/base2/css/base.min.gz.css?u=1596213612000" id="styles-base">

				<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="https://s.wayin.com/themes/base2/css/ie8.min.gz.css?u=1596213612000" id="styles-legacy-base"><![endif]-->
<link rel="stylesheet" type="text/css" href="https://s.wayin.com/themes/scaffold2/css/theme.min.gz.css?u=1596213612000" id="styles-foundation">

			<!--[if lt IE 9]><link rel="stylesheet" type="text/css" href="https://s.wayin.com/themes/scaffold2/css/ie8.min.gz.css?u=1596213612000" id="styles-legacy-foundation"><![endif]-->
<link rel="stylesheet" type="text/css" href="https://a.wayin.com/themes/5365/165885/theme.min.gz.css?u=1596213803000" id="styles-overrides">
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body  class="@yield('state')   xModula notEntered xEmbedFixed xFormatWidget has7Pages isPrelaunchPhase noParticipantWall noIncentiveData xCampaignPage xBody xCampaignSweepstake noSponsor noBGImage noFeatureImage noMainImage noCountdown hasForm noWizard " data-ngx-tracking="">
    <main class="xPage">
        <div class="xPageInner">
            <section id='@yield('id')' class='xSection @yield('class') xSectionContent' data-stateName='@yield('class')' data-ngx-id='598109'>
                <div class='xSectionInner'>
                @yield("content")
                </div>
            </section>
        </div>
    </main>
        <script src="js/app.js"></script>
    </body>
</html>