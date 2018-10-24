<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

use App\User;

class UsersTableSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {

    $faker = Faker::create();

    if( User::count() <= 0 )
    {

      $users = [
        'Jason Holland'     => 'jholland@opentext.com',
        'Stephen Cittadini' => 'scittadi@opentext.com',
        'Parth Sharma'      => 'parths@opentext.com'
      ];

      foreach ( $users as $name => $email )
      {

        $user = User::where( 'email', $email )->first();

        if( ! isset( $user ) )
        {
          $user = new User();
        }
        
        $user->name     = $name;
        $user->email    = $email;
        $password       = $faker->regexify( '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$' );
        $user->password = bcrypt( $password );
        $user->is_admin = 1;
        $user->save();

        error_log( 'USERNAME: ' . $email );
        error_log( 'PASSWORD: ' . $password );

      }

    }
    else
    {
      error_log( 'Users already exist.' );
    }

  }

  /****************************************************************************/

}
