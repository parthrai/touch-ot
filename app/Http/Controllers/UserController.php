<?php

namespace App\Http\Controllers;

use Exception;
use Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\User;
use App\Mail\TokenEmail;

class UserController extends Controller
{

  /****************************************************************************/

  public function index()
  {

    $users = User::all();

    return(
      view( 'users.index' )
      ->with(
        [ 'users' => $users ]
      )
    );

  }

  /****************************************************************************/

  public function createUserToken()
  {

    $user  = \Auth::user();
    $token = $user->createToken( $user->email, [] )->accessToken;

    Mail::to( $user->email )->send( new TokenEmail( $token ) );

  }

  /****************************************************************************/

  public function giveUserAdminPermissions ( Request $request )
  {
    
    $id   = $request['id'];
    $user = User::find($id);

    $user->is_admin = True;
    $user->save();

    return(
      back()
      ->with( [ 'flash_success' => 'You have successfully updated the users admin access.' ] )
    );

  }

  /****************************************************************************/

  /**
   * Remove admin access for a user
   * 
   */
  public function removeUserAdminPermissions ( Request $request )
  {
  
    $id   = $request['id'];
    $user = User::find( $id );

    if( $user->id == \Auth::user()->id )
    {
      return(
        back()
        ->with( [ 'flash_error' => 'You cannot update your own admin access.' ] )
      );
    }

    $user->is_admin = false;
    $user->save();

    return(
      back()
      ->with( [ 'flash_success' => 'You have successfully removed this users admin access.' ] )
    );
  
  }

  /****************************************************************************/

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create ( Request $request )
  {


    if( $request->isMethod( 'post' ) )
    {

      try
      {

        $user           = new User();
        $user->name     =  $request->input( 'name' );
        $user->email    = $request->input( 'email' );
        $user->password = bcrypt( $request->input( 'password' ) );
        $user->save();

      }
      catch( Exception $ex ) 
      {

        return(
          back()
          ->with(
            [
              'flash_error'     => 'Failed to create new user.',
              'flash_exception' => $ex->getMessage()
            ]
          )
        );

      }

      return(
        back()
        ->with( [ 'flash_success' => 'New Users Added' ] )
      );

    }
    else
    {
      return(
        view('users.create')
      );
    }

  }

  /****************************************************************************/

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store ( Request $request )
  {
    // NO-OP
  }

  /****************************************************************************/

  /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function show ( $id )
  {
    // NO-OP
  }

  /****************************************************************************/

  /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function edit ( $id )
  {
    // NO-OP
  }

  /****************************************************************************/

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function update ( Request $request, $id )
  {
    // NO-OP
  }

  /****************************************************************************/

  public function delete( $id, Request $request )
  {

    $users = User::find( $id );

    if( ! $users )
    {
      return 'We cannot locate this record to delete';
    }

    $users->delete();

    return(
      back()
      ->with( [ 'flash_success' => 'User Deleted' ] )
    );

  }


  /****************************************************************************/

}
