@extends('layouts.admin-event')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
          <div class="panel-heading">Reports</div>
          <div class="panel-body">
            <div id="overallScores"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('head')

  @parent

  <!--Load the AJAX API-->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript" src="/js/ewcharts.js"></script>

  <script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});
    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(ewcharts.overallScore);
  </script>

@endsection

