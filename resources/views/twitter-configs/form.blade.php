<form
  class="form-inline"
  enctype="multipart/form-data"
  method="POST"
  action="{{ route( 'twitter-hashtags.add', [ 'event_instance_name' => $event_instance_name ] ) }}"
>

  {{ csrf_field() }}

  <!-- BEGIN: Hashtag ****************************************************** -->
  <div class="form-group{{ $errors->has('hashtag') ? ' has-error' : '' }}">
    <label
      for="hashtag"
      class="control-label"
    >Hashtag:</label>
    <input
      class="form-control"
      name="hashtag"
      type="text"
      required
      autofocus
    >
    @if( $errors->has( 'hashtag' ) )
      <span class="help-block">
        <strong>{{ $errors->first('hashtag') }}</strong>
      </span>
    @endif
  </div>
  <!-- END: Hashtag ******************************************************** -->

  <!-- BEGIN: Submit ******************************************************* -->
  <div class="form-group">
    <input type="submit" class="btn btn-primary" value="Add Hashtag">
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
