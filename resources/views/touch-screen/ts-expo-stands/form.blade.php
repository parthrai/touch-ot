<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action=""
>

  {{ csrf_field() }}

  <!-- BEGIN: Exhibitor Level ********************************************** -->
  <div class="form-group{{ $errors->has('expo_level_id') ? ' has-error' : '' }}">
    <label for="expo_level_id" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Exhibitor Level</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <select
        class="form-control"
        name="expo_level_id"
      >
        <option value="">-- Select Exhibitor Level --</option>
        @if( isset( $expo_stand ) )
          @foreach( $expo_levels as $expo_level )
            @if( $expo_stand->expo_level_id == $expo_level->id )
              <option
                value="{{ $expo_level->id }}"
                selected="selected"
              >{{ $expo_level->name }}</option>
            @else
              <option
                value="{{ $expo_level->id }}"
              >{{ $expo_level->name }}</option>
            @endif
          @endforeach
        @else
          @foreach( $expo_levels as $expo_level )
            <option
              value="{{ $expo_level->id }}"
            >{{ $expo_level->name }}</option>
          @endforeach
        @endif
      </select>
      @if( $errors->has( 'expo_level_id' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'expo_level_id' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Exhibitor Level ************************************************ -->

<!-- BEGIN: Exhibitor ****************************************************** -->
  <div class="form-group{{ $errors->has('exhibitor') ? ' has-error' : '' }}">
    <label for="exhibitor" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Exhibitor</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <input
        class="form-control"
        type="text"
        name="exhibitor"
        value="{{ isset( $expo_stand->exhibitor ) ? $expo_stand->exhibitor : '' }}"
        required
      >
      @if( $errors->has( 'exhibitor' ) )
        <span class="help-block">
          <strong>{{ $errors->first('exhibitor') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Exhibitor ****************************************************** -->

  <!-- BEGIN: Stand ******************************************************** -->
  <div class="form-group{{ $errors->has('stand') ? ' has-error' : '' }}">
    <label for="stand" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Stand</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <input
        class="form-control"
        type="text"
        name="stand"
        value="{{ isset( $expo_stand->stand ) ? $expo_stand->stand : '' }}"
        required
      >
      @if( $errors->has( 'stand' ) )
        <span class="help-block">
          <strong>{{ $errors->first('stand') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Stand ********************************************************** -->

  <!-- BEGIN: Expo Map ID ************************************************** -->
  <div class="form-group{{ $errors->has('expo_map_id') ? ' has-error' : '' }}">
    <label for="expo_map_id" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Expo Map</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <select
        class="form-control"
        id="expo_map_id"
        name="expo_map_id"
      >
        <option value="">-- Select Expo Map --</option>
        @if( isset( $expo_stand ) )
          @foreach( $expo_maps as $expo_map )
            @if( $expo_stand->expo_map_id == $expo_map->id )
              <option
                value="{{ $expo_map->id }}"
                selected="selected"
              >{{ $expo_map->name }}</option>
            @else
              <option
                value="{{ $expo_map->id }}"
              >{{ $expo_map->name }}</option>
            @endif
          @endforeach
        @else
          @foreach( $expo_maps as $expo_map )
            <option
              value="{{ $expo_map->id }}"
            >{{ $expo_map->name }}</option>
          @endforeach
        @endif
      </select>
      @if( $errors->has( 'expo_map_id' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'expo_map_id' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Expo Map ID **************************************************** -->

  <!-- BEGIN: Coordinates ************************************************** -->
  <div class="form-group">
    <label class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Click to Set Coordinates:</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">

      <div style="position:relative;">
        <img
          id="expo_stands_coordinates_picker"
          src="{{ isset( $expo_stand->expo_map ) ? '/storage/' . $expo_stand->expo_map->touchscreen_image->image_lg : '' }}"
          class="img-responsive expo-stands-coordinates-picker"
          style="display:none;"
        >
        <img
          id="expo_stands_blackspot"
          class="expo-stands-blackspot"
          src="/images/touchscreen/expo-maps/blackspot.png"
          style="display:none;"
        >
      </div>

    </div>
  </div>
  <!-- END: Coordinates **************************************************** -->

  <!-- BEGIN: Position X *************************************************** -->
  <div class="form-group{{ $errors->has('position_x') ? ' has-error' : '' }}">
    <label for="position_x" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Position X</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <input
        class="form-control"
        type="number"
        step="0.0001"
        id="position_x"
        name="position_x"
        value="{{ isset( $expo_stand->position_x ) ? $expo_stand->position_x : '0.0' }}"
        required
      >
      @if( $errors->has( 'position_x' ) )
        <span class="help-block">
          <strong>{{ $errors->first('position_x') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Position X ***************************************************** -->

  <!-- BEGIN: Position Y *************************************************** -->
  <div class="form-group{{ $errors->has('position_y') ? ' has-error' : '' }}">
    <label for="position_y" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Position Y</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <input
        class="form-control"
        type="number"
        step="0.0001"
        id="position_y"
        name="position_y"
        value="{{ isset( $expo_stand->position_y ) ? $expo_stand->position_y : '0.0' }}"
        required
      >
      @if( $errors->has( 'position_y' ) )
        <span class="help-block">
          <strong>{{ $errors->first('position_y') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Position Y ***************************************************** -->

  <!-- BEGIN: Hidden ******************************************************* -->
  <div class="form-group{{ $errors->has('hidden') ? ' has-error' : '' }}">
    <label for="hidden" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Hidden</label>
    <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
      <select
        class="form-control"
        name="hidden"
      >
        <option value="">-- Choose Hidden Status --</option>
        @if( isset( $expo_stand ) )
          @if( $expo_stand->hidden == true )
            <option
              value="{{ false }}"
            >Visible Stand</option>
            <option
              value="{{ true }}"
              selected="selected"
            >Hidden Stand</option>
          @else
            <option
              value="{{ false }}"
              selected="selected"
            >Visible Stand</option>
            <option
              value="{{ true }}"
            >Hidden Stand</option>
          @endif
        @else
          <option
            value="{{ false }}"
            selected="selected"
          >Visible Stand</option>
          <option
            value="{{ true }}"
          >Hidden Stand</option>
        @endif
      </select>
      @if( $errors->has( 'hidden' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'hidden' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Hidden  ******************************************************** -->

<!-- BEGIN: Submit ******************************************************* -->
  <div class="form-group">
    <div
      class="
        col-xs-2
        col-sm-2
        col-md-2
        col-lg-2
        col-xs-offset-4
        col-sm-offset-4
        col-md-offset-4
        col-lg-offset-4
      "
    >
      <button type="submit" class="btn btn-primary">
        Submit
      </button>
    </div>
    <div
      class="
        col-xs-2
        col-sm-2
        col-md-2
        col-lg-2
      "
    >
      <a
        class="btn btn-danger"
        href="{{ route( 'ts-expo-stands', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>

@section('script')
  <script type="text/javascript">

    $(window).ready(
      function ()
      {

        var expo_maps = [];


        @foreach( $expo_maps as $expo_map )
          expo_maps[{{ $expo_map->id }}] = "{{ $expo_map->touchscreen_image->image_lg }}";
        @endforeach

        window.InitExpoMapCoordPicker( 'expo_stands_coordinates_picker', 'expo_stands_blackspot' );

        window.ExpoMapCoordSetupImage();

        window.ExpoMapCoordMapSelect( expo_maps );

        let field_position_x = document.getElementById( 'position_x' );
        let field_position_y = document.getElementById( 'position_y' );

        window.ExpoMapCoordPickerPositionBlackspot(
          'expo_stands_coordinates_picker',
          'expo_stands_blackspot',
          field_position_x.value,
          field_position_y.value
        );

        $(window).resize(
          function ()
          {
        
            let field_position_x   = document.getElementById( 'position_x' );
            let field_position_y   = document.getElementById( 'position_y' );
        
            window.ExpoMapCoordPickerPositionBlackspot(
              'expo_stands_coordinates_picker',
              'expo_stands_blackspot',
              field_position_x.value,
              field_position_y.value
            );
        
          }
        );

      }
    );

  </script>
@endsection
