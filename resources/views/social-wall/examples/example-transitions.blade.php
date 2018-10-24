@extends('layouts.examples')

@section('js-static')
@endsection

@section('content')

  <transitioner
    :settings-frequency-ms="5000"
    :transition-frequency-ms="5000"
  >
    <div class="item">
      <test-card test-card-image-url="/images/opentext-logos/OpenText-Logo-2017.png"></test-card>
    </div>
    <div class="item"><div class="thingy">Slide 2</div></div>
    <div class="item"><div class="thingy">Slide 3</div></div>
    <div class="item"><div class="thingy">Slide 4</div></div>
    <div class="item"><div class="thingy">Slide 5</div></div>
  </transitioner>

@endsection

@section( 'script' )
  <style type="text/css">
    .thingy
    {
      font-size:100px;
      text-align:center;
      background-color:red;
      width:100%;
      height:100%;
      min-height:80vh;
    }
    .thingy:nth-child(2)
    {
      background-color:blue;
    }
    .thingy:nth-child(3)
    {
      background-color:green;
    }
    .thingy:nth-child(4)
    {
      background-color:yellow;
    }
  </style>
  <script type="text/javascript">
    $(document).ready(
      function ()
      {
      }
    );
  </script>
@endsection
