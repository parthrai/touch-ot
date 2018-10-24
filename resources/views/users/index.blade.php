@extends('layouts.admin-default')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">

        @include( 'includes.flash-messages' )

        <div class="panel panel-primary">
          <div class="panel-heading">Users Dashboard</div>
          <div class="panel-body">

            <ul class="list-unstyled list-inline">
              <li><a class="btn btn-primary" href="{{ route('newuser') }}">Add User</a></li>
            </ul>

            <!-- Users Table -->
            <table class="table table-bordered table-striped table-condensed">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Created At</th>
                  <th>Admin</th>
                  <th>Edit</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>

                @foreach( $users as $user )
                  <tr>
                  
                    <td>{{ $user->id }}</td>
                    
                    <td>{{ $user->name }}</td>
                    
                    <td>{{ $user->email }}</td>
                    
                    <td>{{ $user->created_at }}</td>
                    
                    <td>
                      @if( Auth::user()->id == $user->id )
                        <input type="checkbox" name="admin" value="admin" disabled />
                      @elseif( $user->is_admin )
                        <input type="checkbox" name="admin" value="admin" onClick="otAjax.rm_admin({{ $user->id }})" checked>
                      @else
                        <input type="checkbox" name="admin" value="admin" onClick="otAjax.add_admin({{ $user->id }})">
                      @endif
                    </td>

                    <td><a href="#"><span class="glyphicon glyphicon-pencil"></span></a></td>
                    
                    <td>
                      {!! Form::open(['method' => 'DELETE','route' => ['user.delete', $user->id],'style'=>'display:inline']) !!}
                      {{ Form::button('<span class="glyphicon glyphicon-trash"></span>', array('class'=>'btn btn-danger', 'type'=>'submit')) }}
                      {!! Form::close() !!}
                    </td>

                  </tr>
                @endforeach

              </tbody>
            </table>

            <passport-clients></passport-clients>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
