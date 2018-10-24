<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action=""
>

  {{ csrf_field() }}

  <!-- BEGIN: Name ********************************************************* -->
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Name</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="name"
        value="{{ isset( $expo_map->name ) ? $expo_map->name : '' }}"
        required
      >
      @if( $errors->has( 'name' ) )
        <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Name *********************************************************** -->

  <!-- BEGIN: Touchscreen Image ******************************************** -->
  <div class="form-group{{ $errors->has('touchscreen_image_id') ? ' has-error' : '' }}">
    <label for="touchscreen_image_id" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Touchscreen Image</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="touchscreen_image_id"
      >
        <option value="">-- Select Touch Screen Image --</option>
        @if( isset( $expo_map ) )
          @foreach( $touchscreen_images as $touchscreen_image )
            @if( $expo_map->touchscreen_image_id == $touchscreen_image->id )
              <option
                value="{{ $touchscreen_image->id }}"
                selected="selected"
              >{{ $touchscreen_image->name }}</option>
            @else
              <option
                value="{{ $touchscreen_image->id }}"
              >{{ $touchscreen_image->name }}</option>
            @endif
          @endforeach
        @else
         @foreach( $touchscreen_images as $touchscreen_image )
            <option
              value="{{ $touchscreen_image->id }}"
            >{{ $touchscreen_image->name }}</option>
          @endforeach
        @endif
      </select>
      @if( $errors->has( 'touchscreen_image_id' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'touchscreen_image_id' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Touchscreen Image ********************************************** -->

  <!-- BEGIN: Default ****************************************************** -->
  <div class="form-group{{ $errors->has('default') ? ' has-error' : '' }}">
    <label for="default" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Default Map</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="default"
      >
        <option value="">-- Choose Default Map Status --</option>
        @if( isset( $expo_map ) )
          @if( $expo_map->default == true )
            <option
              value="{{ true }}"
              selected="selected"
            >Is Default Map</option>
            <option
              value="{{ false }}"
            >Is Not Default Map</option>
          @else
            <option
              value="{{ true }}"
            >Is Default Map</option>
            <option
              value="{{ false }}"
              selected="selected"
            >Is Not Default Map</option>
          @endif
        @else
          <option
            value="{{ true }}"
          >Is Default Map</option>
          <option
            value="{{ false }}"
          >Is Not Default Map</option>
        @endif
      </select>
      @if( $errors->has( 'default' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'default' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Default ******************************************************** -->

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
        href="{{ route( 'ts-expo-maps', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
