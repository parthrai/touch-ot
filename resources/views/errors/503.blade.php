@extends('layouts.errors')

@section('content')
  <div class="panel panel-primary">
    <div class="panel-heading">Application Error</div>
    <div class="panel-body">
      <p class="lead text-danger">{{ $exception->getMessage() }}</p>
    </div>
  </div>
@endsection
