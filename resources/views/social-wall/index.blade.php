@extends('layouts.wonder-wall')

@section('js-static')
@endsection

@section('content')

  <wallpaper-rorschach
    :debug="{{ $debug_mode }}"
    :transition-frequency-ms="8333"
  ></wallpaper-rorschach>

  <transitioner
    :debug="{{ $debug_mode }}"
    event-instance-name="{{ $event_instance_name }}"
    :settings-frequency-ms="5500"
    :transition-frequency-ms="5000"
  >

    <!-- BEGIN: Test Card ************************************************** -->
    @if( array_key_exists( 'test_card', $screen_settings ) )
      <div
        id="transition-test_card"
        data-screen-name="test_card"
        class="item"
      >
        <test-card test-card-image-url="/images/opentext-logos/OpenText-Logo-INV-2017.png"></test-card>
      </div>
    @endif
    <!-- END: Test Card **************************************************** -->

    <!-- BEGIN: Countdown Screen ******************************************* -->
    @if( array_key_exists( 'countdown', $screen_settings ) )
      <div
        id="transition-{{ 'countdown' }}"
        data-screen-name="{{ 'countdown' }}"
        class="{{ $screen_settings['countdown'] ? 'item' : 'item item-hidden' }}"
      >
        <final-countdown
          :debug="{{ $debug_mode }}"
          event-instance-name="{{ $event_instance_name }}"
          title="{{ $final_countdown->title }}"
          target-date="{{ $final_countdown->target_date }}T{{ $final_countdown->target_time }}"
          :recalc-frequency-ms="1000"
          :dots-frequency-ms="400"
        ></final-countdown>
      </div>
    @endif
    <!-- END: Countdown Screen ********************************************* -->

    <!-- BEGIN: Announcement Screen **************************************** -->
    @if( array_key_exists( 'announcement', $screen_settings ) )
      <div
        id="transition-{{ 'announcement' }}"
        data-screen-name="{{ 'announcement' }}"
        class="{{ $screen_settings['announcement'] ? 'item' : 'item item-hidden' }}"
      >
        <announcement-screen
          :debug="{{ $debug_mode }}"
          event-instance-name="{{ $event_instance_name }}"
          :schedule-frequency-ms="5000"
        ></announcement-screen>
      </div>
    @endif
    <!-- END: Announcement Screen ****************************************** -->

    <!-- BEGIN: Logo Screen ************************************************ -->
    @if( array_key_exists( 'splash_screen', $screen_settings ) )
      <div
        id="transition-{{ 'splash_screen' }}"
        data-screen-name="{{ 'splash_screen' }}"
        class="{{ $screen_settings['splash_screen'] ? 'item' : 'item item-hidden' }}"
      >
        <logo-screen
          :debug="{{ $debug_mode }}"
          event-instance-name="{{ $event_instance_name }}"
          logo-url="/images/opentext-logos/OpenText-Logo-2017.png"
        ></logo-screen>
      </div>
    @endif
    <!-- BEGIN: Logo Screen ************************************************ -->

    <!-- BEGIN: Team Rankings ********************************************** -->
    @if( array_key_exists( 'team_ranking', $screen_settings ) )
      <div
        id="transition-{{ 'team_ranking' }}"
        data-screen-name="{{ 'team_ranking' }}"
        class="{{ $screen_settings['team_ranking'] ? 'item' : 'item item-hidden' }}"
      >
        <scoreboard-teams
          :debug="{{ $debug_mode }}"
          event-instance-name="{{ $event_instance_name }}"
          :schedule-frequency-ms="30000"
        ></scoreboard-teams>
      </div>
    @endif
    <!-- END: Team Rankings ************************************************ -->

    <!-- BEGIN: Team Member Rankings *************************************** -->
    @if( count( $team_sets ) > 0 )
      @foreach( $team_sets[0] as $team_name => $team_details )
        @php
          $team_ranking_screen = join( '_', [ 'team_members_ranking', strtolower( $team_name ) ] );
        @endphp
        @if( array_key_exists( $team_ranking_screen, $screen_settings ) )
          <div
            id="transition-{{ $team_ranking_screen }}"
            data-screen-name="{{ $team_ranking_screen }}"
            class="{{ $screen_settings[$team_ranking_screen] ? 'item' : 'item item-hidden' }}"
          >
            <scoreboard-team-members
              :debug="{{ $debug_mode }}"
              event-instance-name="{{ $event_instance_name }}"
              team-name="{{ $team_name }}"
              team-hashtag="{{ $team_details['team_hashtag'] }}"
              team-background-color="{{ $team_details['team_background_color'] }}"
              team-text-color="{{ $team_details['team_text_color'] }}"
              :schedule-frequency-ms="30000"
            ></scoreboard-team-members>
          </div>
        @endif
      @endforeach
    @endif
    <!-- END: Team Member Rankings ***************************************** -->

    <!-- BEGIN: Social Cards *********************************************** -->
    @if( array_key_exists( 'social_cards', $screen_settings ) )
      <div
        id="transition-{{ 'social_cards' }}"
        data-screen-name="{{ 'social_cards' }}"
        class="{{ $screen_settings['social_cards'] ? 'item' : 'item item-hidden' }}"
      >
        <social-cards-columns
          :debug="{{ $debug_mode }}"
          event-instance-name="{{ $event_instance_name }}"
          :max-cards="{{ $social_cards_config->display_max_items }}"
          :max-featured-cards="2"
          :schedule-frequency-ms="5000"
        ></social-cards-columns>
      </div>
    @endif
    <!-- END: Social Cards ************************************************* -->

    <!-- BEGIN: Team Member Rankings *************************************** -->
    @if( count( $team_sets ) > 0 )
      @foreach( $team_sets[1] as $team_name => $team_details )
        @php
          $team_ranking_screen = join( '_', [ 'team_members_ranking', strtolower( $team_name ) ] );
        @endphp
        @if( array_key_exists( $team_ranking_screen, $screen_settings ) )
          <div
            id="transition-{{ $team_ranking_screen }}"
            data-screen-name="{{ $team_ranking_screen }}"
            class="{{ $screen_settings[$team_ranking_screen] ? 'item' : 'item item-hidden' }}"
          >
            <scoreboard-team-members
              :debug="{{ $debug_mode }}"
              event-instance-name="{{ $event_instance_name }}"
              team-name="{{ $team_name }}"
              team-hashtag="{{ $team_details['team_hashtag'] }}"
              team-background-color="{{ $team_details['team_background_color'] }}"
              team-text-color="{{ $team_details['team_text_color'] }}"
              :schedule-frequency-ms="30000"
            ></scoreboard-team-members>
          </div>
        @endif
      @endforeach
    @endif
    <!-- END: Team Member Rankings ***************************************** -->

    <!-- BEGIN: Leaderboard Screens **************************************** -->
    @if( array_key_exists( 'leaderboards', $screen_settings ) )
      @foreach( \App\Leaderboard::GetLeaderboardOrders( $event_instance_name ) as $order )
        @php
          $leaderboard_id = join( '_', [ 'leaderboard', $order ] );
        @endphp
        <div
          id="transition-{{ $leaderboard_id }}"
          data-screen-name="{{ $leaderboard_id }}"
          class="{{ $screen_settings[$leaderboard_id] ? 'item' : 'item item-hidden' }}"
        >
          <leaderboard-screen
            :debug="{{ $debug_mode }}"
            event-instance-name="{{ $event_instance_name }}"
            :screen-order="{{ $order }}"
            :schedule-frequency-ms="10000"
          ></leaderboard-screen>
        </div>
      @endforeach
    @else
      <!-- NO LEADERBOARDS FOUND -->
    @endif
    <!-- END: Leaderboard Screens ****************************************** -->

  </transitioner>

@endsection

@section( 'script' )
@endsection
