<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\EventInstance;

class EventInstancesSeeder extends Seeder
{

  /****************************************************************************/

  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run ()
  {
    $instance = EventInstance::GetDefaultInstance();
  }

  /****************************************************************************/

}
