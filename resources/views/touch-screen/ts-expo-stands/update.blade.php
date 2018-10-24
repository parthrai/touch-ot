@extends('layouts.admin-event')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div
        class="
          col-xs-12
          col-sm-12
          col-md-12
          col-lg-12
        "
      >
        @include( 'includes.flash-messages' )
        <div class="panel panel-primary">
          <div class="panel-heading">Update Expo Stand</div>
          <div class="panel-body">
            @include( 'touch-screen.ts-expo-stands.form' )
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
