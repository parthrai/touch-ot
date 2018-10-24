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
        value="{{ isset( $image->name ) ? $image->name : '' }}"
        required
        autofocus
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
  @foreach( \App\TouchscreenImage::$image_sizes as $image_size )
    <div class="form-group{{ $errors->has( $image_size ) ? ' has-error' : '' }}">
      <label for="image" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Image {{ strtoupper( substr( $image_size , -2, 2 ) ) }}</label>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <input
          type="file"
          id="{{ $image_size }}"
          name="{{ $image_size }}"
          {{ $image_size == \App\TouchscreenImage::$image_sizes[0] ? 'required' : '' }}
        >
        @if( $errors->has( $image_size ) )
          <span class="help-block">
            <strong>{{ $errors->first( $image_size ) }}</strong>
          </span>
        @endif
        @isset( $image[$image_size] )
          <img
            src="{{ Storage::url( $image[$image_size] ) }}"
            style="width:100px;"
          >
        @endisset
      </div>
    </div>
  @endforeach
  <!-- END: Image ********************************************************** -->

  <!-- BEGIN: Link ********************************************************* -->
  <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
    <label for="link" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Link URL</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="link"
        value="{{ isset( $image->link ) ? $image->link : '' }}"
      >
      @if( $errors->has( 'link' ) )
        <span class="help-block">
          <strong>{{ $errors->first('link') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Link *********************************************************** -->

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
        href="{{ route( 'ts-images', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
