<?php

use Faker\Factory as Faker;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

use App\TouchscreenImage;
use App\AgendaAnnouncement;
use App\AgendaScheduleEvent;
use App\AgendaBreakoutSession;

class AgendaSeeder extends Seeder
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

    AgendaAnnouncement::whereNotNull('id')->forceDelete();
    AgendaScheduleEvent::whereNotNull('id')->forceDelete();
    AgendaBreakoutSession::whereNotNull('id')->forceDelete();

    $this->SeedAgendaBreakoutSessions( $faker, 100 );
    $this->SeedAgendaScheduleEvents( $faker, 100 );
    $this->SeedAgendaAnnouncements( $faker, 100 );
    
  }

  /****************************************************************************/

  public function SeedAgendaAnnouncements ( $faker, $max = 500 )
  {

    for( $i = 0 ; $i < $max ; $i++ )
    {
      $announcement               = new AgendaAnnouncement();
      $announcement->announcement = $faker->bs();
      $announcement->save();
    }

  }

  /****************************************************************************/

  public function SeedAgendaScheduleEvents ( $faker, $max = 500 )
  {

    for( $i = 0 ; $i < $max ; $i++ )
    {
      $event                = new AgendaScheduleEvent();
      $event->session_id    = $faker->uuid();
      $event->date          = $faker->dateTimeBetween( '+7 days', '+14 days', null );
      $time_start           = $faker->numberBetween( 9, 16 );
      $event->time_start    = join( ':', [ $time_start, 0, 0 ] );
      $event->time_end      = join( ':', [ $time_start + $faker->numberBetween( 1, 5 ), 0, 0 ] );
      $event->display_order = $i + 1;
      $event->title         = $faker->bs();
      $event->description   = $faker->bs();
      $event->location      = $faker->streetName();
      $event->save();
    }

  }

  /****************************************************************************/

  public function SeedAgendaBreakoutSessions ( $faker, $max = 500 )
  {

    for( $i = 0 ; $i < $max ; $i++ )
    {

      $time_start = $faker->numberBetween( 9, 12 );
      $time_end   = $time_start + $faker->numberBetween( 1, 5 );

      for( $j = 0 ; $j < $faker->numberBetween( 1, intval( $max / 10 ) + 1 ) ; $j++ )
      {

        $breakout                = new AgendaBreakoutSession();
        $breakout->session_id    = $faker->uuid();
        $breakout->date          = $faker->dateTimeBetween( '+7 days', '+14 days', null );
        $breakout->time_start    = join( ':', [ $time_start, 0, 0 ] );
        $breakout->time_end      = join( ':', [ $time_end, 0, 0 ] );
        $breakout->display_order = $i + 1;
        $breakout->icon          = $faker->randomElement( [ 'cloud' ] );
        $breakout->title         = $faker->bs();
        $breakout->description   = $faker->bs();
        $breakout->location      = $faker->streetName();
        $breakout->save();

      }

    }

  }

  /****************************************************************************/

}
