@extends('layouts.admin-default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        @include( 'includes.flash-messages' )

        <div class="panel panel-default">
          <div class="panel-heading">Add New User</div>
          <div class="panel-body">
            @include( 'users.create-form' )
          </div>
        </div>
        
      </div>
    </div>
  </div>
@endsection
