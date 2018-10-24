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
        value="{{ isset( $screen->name ) ? $screen->name : '' }}"
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

  <!-- BEGIN: Active ******************************************************* -->
  <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
    <label for="active" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Active</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="active"
      >
        @if( isset( $screen ) )
          @if( $screen->active == true )
            <option
              value="{{ false }}"
            >Inactive</option>
            <option
              value="{{ true }}"
              selected="selected"
            >Active</option>
          @else
            <option
              value="{{ false }}"
            >Inactive</option>
            <option
              value="{{ true }}"
            >Active</option>
          @endif
        @else
          <option
            value="{{ false }}"
          >Inactive</option>
          <option
            value="{{ true }}"
          >Active</option>
        @endif
      </select>
      @if( $errors->has( 'active' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'active' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Active ********************************************************* -->

  <!-- BEGIN: Tab Label **************************************************** -->
  <div class="form-group{{ $errors->has('tab_label') ? ' has-error' : '' }}">
    <label for="tab_label" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Tab Label</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="tab_label"
        value="{{ isset( $screen->tab_label ) ? $screen->tab_label : '' }}"
        required
      >
      @if( $errors->has( 'tab_label' ) )
        <span class="help-block">
          <strong>{{ $errors->first('tab_label') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Tab Label ****************************************************** -->

  <!-- BEGIN: Display Order ************************************************ -->
  <div class="form-group{{ $errors->has('display_order') ? ' has-error' : '' }}">
    <label for="display_order" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Display Order</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="display_order"
      >
        @if( isset( $screen ) )
          @for( $i = 1 ; $i <= 100 ; $i++ )
            @if( $screen->display_order == $i )
              <option
                value="{{ $i }}"
                selected="selected"
              >{{ $i }}</option>
            @else
              <option
                value="{{ $i }}"
              >{{ $i }}</option>
            @endif
          @endfor
        @else
          @for( $i = 1 ; $i <= 100 ; $i++ )
            <option
              value="{{ $i }}"
            >{{ $i }}</option>
          @endfor
        @endif
      </select>
      @if( $errors->has( 'display_order' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'display_order' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Display Order ************************************************** -->

  <!-- BEGIN: Caption ****************************************************** -->
  <div class="form-group{{ $errors->has('caption') ? ' has-error' : '' }}">
    <label for="caption" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Caption</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        class="form-control"
        type="text"
        name="caption"
        value="{{ isset( $screen->caption ) ? $screen->caption : '' }}"
        required
      >
      @if( $errors->has( 'caption' ) )
        <span class="help-block">
          <strong>{{ $errors->first('caption') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Caption ******************************************************** -->

  <!-- BEGIN: Touchscreen Image ******************************************** -->
  <div class="form-group{{ $errors->has('touchscreen_image_id') ? ' has-error' : '' }}">
    <label for="touchscreen_image_id" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Touchscreen Image</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="touchscreen_image_id"
      >
        <option value="">-- Select Touch Screen Image --</option>
        @if( isset( $screen ) )
          @foreach( $touchscreen_images as $touchscreen_image )
            @if( $screen->touchscreen_image_id == $touchscreen_image->id )
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
        href="{{ route( 'ts-map-screens', [ 'event_instance_name' => $event_instance_name ] ) }}"
      >Cancel</a>
    </div>
  </div>
  <!-- END: Submit ********************************************************* -->

</form>
