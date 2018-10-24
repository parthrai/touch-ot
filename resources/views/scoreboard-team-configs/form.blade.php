<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action=""
>

  {{ csrf_field() }}

  <!-- BEGIN: Event Instance *********************************************** -->
  <input
    id="event_instance_name"
    name="event_instance_name"
    type="hidden"
    value="{{ $event_instance_name ? $event_instance_name : '' }}"
  >
  <!-- END: Event Instance ************************************************* -->

  <!-- BEGIN: Name ********************************************************* -->
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-4 control-label">Name</label>
    <div class="col-md-6">
      <input
        class="form-control"
        id="name"
        name="name"
        type="text"
        required
        autofocus
        value="{{ $team->name ? $team->name : '' }}"
      >
      @if( $errors->has( 'name' ) )
        <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Name *********************************************************** -->

  <!-- BEGIN: Display Name ************************************************* -->
  <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
    <label for="display_name" class="col-md-4 control-label">Display Name</label>
    <div class="col-md-6">
      <input
        class="form-control"
        id="display_name"
        name="display_name"
        type="text"
        required
        autofocus
        value="{{ $team->display_name ? $team->display_name : '' }}"
      >
      @if( $errors->has( 'display_name' ) )
        <span class="help-block">
          <strong>{{ $errors->first('display_name') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Display Name *************************************************** -->

  <!-- BEGIN: Hashtag ****************************************************** -->
  <div class="form-group{{ $errors->has('hashtag') ? ' has-error' : '' }}">
    <label for="hashtag" class="col-md-4 control-label">Hashtag</label>
    <div class="col-md-6">
      <input
        class="form-control"
        id="hashtag"
        name="hashtag"
        type="text"
        required
        autofocus
        value="{{ $team->hashtag ? $team->hashtag : '' }}"
      >
      @if( $errors->has( 'hashtag' ) )
        <span class="help-block">
          <strong>{{ $errors->first('hashtag') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Hashtag ******************************************************** -->

  <!-- BEGIN: Background Colour ******************************************** -->
  <div class="form-group{{ $errors->has('hex_background_color') ? ' has-error' : '' }}">
    <label for="hex_background_color" class="col-md-4 control-label">Background Colour</label>
    <div class="col-md-6">
      <input
        class="form-control"
        id="hex_background_color"
        name="hex_background_color"
        type="color"
        required
        autofocus
        value="{{ $team->hex_background_color ? $team->hex_background_color : '' }}"
      >
      @if( $errors->has( 'hex_background_color' ) )
        <span class="help-block">
          <strong>{{ $errors->first('hex_background_color') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Background Colour ********************************************** -->

  <!-- BEGIN: Text Colour ************************************************** -->
  <div class="form-group{{ $errors->has('hex_text_color') ? ' has-error' : '' }}">
    <label for="hex_text_color" class="col-md-4 control-label">Text Colour</label>
    <div class="col-md-6">
      <input
        class="form-control"
        id="hex_text_color"
        name="hex_text_color"
        type="color"
        required
        autofocus
        value="{{ $team->hex_text_color ? $team->hex_text_color : '' }}"
      >
      @if( $errors->has( 'hex_text_color' ) )
        <span class="help-block">
          <strong>{{ $errors->first('hex_text_color') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Text Colour **************************************************** -->

  <!-- BEGIN: Order ******************************************************** -->
  <div class="form-group{{ $errors->has('invisible') ? ' has-error' : '' }}">
    <label for="invisible" class="col-md-4 control-label">Is Invisible?</label>
    <div class="col-md-6">
      <select
        class="form-control"
        id="invisible"
        name="invisible"
        required="required"
      >
        @if( isset( $team ) && ( $team->invisible == 1 ) )
          <option
            value="0"
          >Visible</option>
          <option
            value="1"
            selected="selected"
          >Invisible</option>
        @else
          <option
            value="0"
            selected="selected"
          >Visible</option>
          <option
            value="1"
          >Invisible</option>
        @endif
      </select>
      @if( $errors->has( 'invisible' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'invisible' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Order ********************************************************** -->

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
        href="{{ route( 'configure-teams', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
