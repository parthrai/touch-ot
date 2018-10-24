<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action=""
>

  {{ csrf_field() }}

  <!-- BEGIN: Announcement ************************************************* -->
  <div class="form-group{{ $errors->has('announcement') ? ' has-error' : '' }}">
    <label for="announcement" class="col-xs-2 col-sm-2 col-md-2 col-lg-2 control-label">Announcement</label>
    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
      <textarea
        class="form-control"
        name="announcement"
        required
        autofocus
      >{{ isset( $announcement->announcement ) ? $announcement->announcement : '' }}</textarea>
      @if( $errors->has( 'announcement' ) )
        <span class="help-block">
          <strong>{{ $errors->first('announcement') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Announcement *************************************************** -->

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
        href="{{ route( 'ts-agenda-announcements', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
