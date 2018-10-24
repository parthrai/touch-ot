<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\AgendaScreen;

class AgendaScreensSeeder extends Seeder
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

    AgendaScreen::whereNotNull('id')->forceDelete();

    $this->SeedAgendaScreens( $faker );
    
  }

  /****************************************************************************/

  public function SeedAgendaScreens ( $faker )
  {

    $entries = [
      [
        'name'      => 'Home',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-07',
        'tab_label' => 'Home'
      ],
      [
        'name'      => 'Overview',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-07',
        'tab_label' => 'Overview'
      ],
      [
        'name'      => 'Updates',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-07',
        'tab_label' => 'Updates'
      ],
      [
        'name'      => 'Saturday',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-07',
        'tab_label' => 'Saturday'
      ],
      [
        'name'      => 'Sunday',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-08',
        'tab_label' => 'Sunday'
      ],
      [
        'name'      => 'Monday',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-09',
        'tab_label' => 'Monday'
      ],
      [
        'name'      => 'Tuesday',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-10',
        'tab_label' => 'Tuesday'
      ],
      [
        'name'      => 'Wednesday',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-11',
        'tab_label' => 'Wednesday'
      ],
      [
        'name'      => 'Thursday',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-12',
        'tab_label' => 'Thursday'
      ],
      [
        'name'      => 'Developer Lab',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-12',
        'tab_label' => 'Developer Lab'
      ],
      [
        'name'      => 'Innnovation Lab',
        'active'    => true,
        'type'      => 'schedule',
        'date'      => '2018-07-12',
        'tab_label' => 'Innnovation Lab'
      ]
    ];

    $display_order = 1;

    foreach( $entries as $entry )
    {

      $screen                = new AgendaScreen();
      $screen->name          = $entry['name'];
      $screen->active        = $entry["active"];
      $screen->type          = $entry["type"];
      $screen->date          = $entry["date"];
      $screen->tab_label     = $entry["tab_label"];
      $screen->display_order = $display_order;

      $screen->save();

      $display_order++;

    }

  }

  /****************************************************************************/

}
