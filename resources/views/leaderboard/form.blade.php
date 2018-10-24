<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action=""
>

  {{ csrf_field() }}

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
        value="{{ isset( $leaderboard ) && $leaderboard->name ? $leaderboard->name : '' }}"
      >
      @if( $errors->has( 'name' ) )
        <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Name *********************************************************** -->

  <!-- BEGIN: Images ******************************************************* -->
  @foreach( \App\Leaderboard::$image_sizes as $image_size )
    <div class="form-group{{ $errors->has( $image_size ) ? ' has-error' : '' }}">
      <label for="image" class="col-md-4 control-label">Image {{ strtoupper( substr( $image_size , -2, 2 ) ) }}</label>
      <div class="col-md-6">
        <input
          type="file"
          id="{{ $image_size }}"
          name="{{ $image_size }}"
          {{ $image_size == \App\Leaderboard::$image_sizes[0] ? 'required' : '' }}
        >
        @if( $errors->has( $image_size ) )
          <span class="help-block">
            <strong>{{ $errors->first( $image_size ) }}</strong>
          </span>
        @endif
        @isset( $leaderboard[$image_size] )
          <img
            src="{{ Storage::url( $leaderboard[$image_size] ) }}"
            style="width:100px;"
          >
        @endisset
      </div>
    </div>
  @endforeach
  <!-- END: Image ********************************************************** -->

  <!-- BEGIN: Display Order ************************************************ -->
  <div class="form-group{{ $errors->has('display_order') ? ' has-error' : '' }}">
    <label for="display_order" class="col-md-4 control-label">Display Order</label>
    <div class="col-md-6">
      <select
        class="form-control"
        id="display_order"
        name="display_order"
        required="required"
      >
        @foreach( range( 1, 32 ) as $new_order )
          @if( isset( $leaderboard ) && ( $leaderboard->display_order == $new_order ) )
            <option
              value="{{ $new_order }}"
              selected="selected"
            >{{ $new_order }}</option>
          @else
            <option
              value="{{ $new_order }}"
            >{{ $new_order }}</option>
          @endif
        @endforeach
      </select>
      @if( $errors->has( 'display_order' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'display_order' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Display Order ************************************************** -->

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
        href="{{ route( 'leaderboard', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
