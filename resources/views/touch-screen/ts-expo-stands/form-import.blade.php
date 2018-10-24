<form
  class="form-horizontal"
  enctype="multipart/form-data"
  method="POST"
  action="{{ route( 'ts-expo-stands.import-from-excel', [ 'event_instance_name' => $event_instance_name ] ) }}"
>

  {{ csrf_field() }}

  <!-- BEGIN: Excel File Upload ******************************************** -->
  <div class="form-group{{ $errors->has('excel_file_upload') ? ' has-error' : '' }}">
    <label for="excel_file_upload" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Excel File</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <input
        type="file"
        accept=".xlsx"
        id="excel_file_upload"
        name="excel_file_upload"
        placeholder="Select Excel file to import"
      >
      @if( $errors->has( 'excel_file_upload' ) )
        <span class="help-block">
          <strong>{{ $errors->first('excel_file_upload') }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Excel File Upload ********************************************** -->

  <!-- BEGIN: Apppend or Replace ******************************************* -->
  <div class="form-group{{ $errors->has('append_or_replace') ? ' has-error' : '' }}">
    <label for="append_or_replace" class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label">Apppend or Replace</label>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
      <select
        class="form-control"
        name="append_or_replace"
        required="required"
      >
        <option value="">-- Please Choose --</option>
        <option value="append">Append</option>
        <option value="replace">Replace</option>
      </select>
      @if( $errors->has( 'append_or_replace' ) )
        <span class="help-block">
          <strong>{{ $errors->first( 'append_or_replace' ) }}</strong>
        </span>
      @endif
    </div>
  </div>
  <!-- END: Apppend or Replace ********************************************* -->

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
        Import
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
