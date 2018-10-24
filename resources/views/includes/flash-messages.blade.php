@if( Session::get( 'flash_success' ) )
  <section>  
    <div class="alert alert-success" role="alert">
      {{ Session::get( 'flash_success' ) }}
    </div>
  </section>
@endif

@if( Session::get( 'flash_error' ) )
  <section>  
    <div class="alert alert-danger" role="alert">
      {{ Session::get( 'flash_error' ) }}
    </div>
  </section>
@endif

@if( Session::get( 'flash_exception' ) )
  <section>  
    <div class="alert alert-danger" role="alert">
      {{ Session::get( 'flash_exception' ) }}
    </div>
  </section>
@endif

