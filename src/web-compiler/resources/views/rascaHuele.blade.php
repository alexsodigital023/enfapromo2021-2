{{-- <!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width" />

  <title>Websanova :: wScratchPad</title>

  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.1.11.0.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/wScratchPad.js') }}"></script>
</head>

<body>

  <div id="demo1" class="scratchpad"></div>
  <div id="demo2" class="scratchpad"></div>
  <div id="demo3" class="scratchpad"></div>
  <div id="demo4" class="scratchpad"></div>

  <br />
  <input type="button" value="Reset" onclick="$('.scratchpad').wScratchPad('reset');" />
  <input type="button" value="Clear" onclick="$('.scratchpad').wScratchPad('clear');" />
  <input type="button" value="Enable" onclick="$('.scratchpad').wScratchPad('enable', true);" />
  <input type="button" value="Disable" onclick="$('.scratchpad').wScratchPad('enable', false);" />

  <style>
    #demo1,
    #demo2,
    #demo3,
    #demo4 {
      width: 25%;
      height: 100px;
      border: solid 1px;
      display: inline-block;
    }
  </style>


  <script type="text/javascript">
    // Test 1
    $('#demo1').wScratchPad({
      scratchMove: function (e, percent) {
        console.log(percent);
      }
    });
   

    // Test 2

    $('#demo2').wScratchPad({

      bg: '{{asset('images/slide1.jpg')}}',
      fg: '#ff0000',
      scratchMove: function (e, percent) {
        console.log(percent);

        if (percent > 70) {
          this.clear();
        }
      }
    });
    
    $('#demo2').wScratchPad('cursor', 'url( "{{ asset('images/cursors/coin.png') }}" ) 5 5, default');

    // Test 3
    // $('#demo3').wScratchPad('reset');
    $('#demo3').wScratchPad({
      cursor: 'url("{{ asset('images/cursors/mario.png') }}") 5 5, default',
      scratchMove: function (e, percent) {
        console.log(percent);
      }
    });

    $('#demo3').wScratchPad('bg', '{{ asset('images/winner.png') }}' );
    $('#demo3').wScratchPad('fg', '{{ asset('images/scratch-to-win.png') }}' );
    $('#demo3').wScratchPad('size', 30);



    $('#demo4').wScratchPad({
      size        : 20,          // The size of the brush/scratch.
      bg          : '#cacaca',  // Background (image path or hex color).
      fg          : '#6699ff',  // Foreground (image path or hex color).
      realtime    : true,       // Calculates percentage in realitime.
      scratchDown : null,       // Set scratchDown callback.
      scratchUp   : null,       // Set scratchUp callback.
      scratchMove : null,       // Set scratcMove callback.
      cursor      : 'crosshair' // Set cursor.
    });

  </script>



</body>

</html> --}}

@extends('layout.Main')
@section('title', '')

@section('content')
<div class="tarjeta-rasca-gana">
  <div class="container">
    <div class="wrapper row">
      <div class="col">
        <rasca :medallas='6' :oportunidades='2' :ganador='0' :p_max='50'>
          
        </rasca>
      </div>
    </div>
  </div>
</div>

@endsection