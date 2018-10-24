/******************************************************************************/

fondleslab_init();

/******************************************************************************/

function fondleslab_init ()
{

  let fondleslab_pads = document.querySelectorAll( '.fondleslab-pad' );

  for( const fondleslab_pad_node in fondleslab_pads )
  {

    let fondleslab_pad_item = fondleslab_pads.item( fondleslab_pad_node );

    fondleslab_pad_item.addEventListener(
      "click",
      fondleslab_show_screen,
      { passive: true }
    );

  }

  let fondleslab_screen_closers = document.querySelectorAll( '.fondleslab-screen-close' );

  for( const fondleslab_screen_close in fondleslab_screen_closers )
  {
    
    let fondleslab_screen_closer_item = fondleslab_screen_closers.item( fondleslab_screen_close );
    
    fondleslab_screen_closer_item.addEventListener(
      "click",
      fondleslab_hide_screen,
      { passive: true }
    );

  }

}

/******************************************************************************/

function fondleslab_show_screen ( ev )
{
  
  console.log( "fondleslab_show_screen:", ev.target );
  console.log( "fondleslab_show_screen:", ev.target.dataset.fondleslabScreen );
  
  let fondleslab_screen_id = ev.target.dataset.fondleslabScreen;

  
  console.log( "fondleslab_screen_id:", fondleslab_screen_id );


  let fondleslab_pads = document.querySelector( '.fondleslab-pads' );

  fondleslab_pads.classList.replace(
    'fondleslab-pads-enter-to',
    'fondleslab-pads-leave-to'
  );

  let fondleslab_screen = document.getElementById( fondleslab_screen_id );

  fondleslab_screen.classList.replace(
    'fondleslab-screen-leave-to',
    'fondleslab-screen-enter-to'
  );

}

/******************************************************************************/

function fondleslab_hide_screen ( ev )
{
  
  console.log( "fondleslab_hide_screen:", ev.target.dataset.fondleslabScreen );

  let fondleslab_screen_id = ev.target.dataset.fondleslabScreen;
  
  let fondleslab_pads = document.querySelector( '.fondleslab-pads' );

  fondleslab_pads.classList.replace(
    'fondleslab-pads-leave-to',
    'fondleslab-pads-enter-to'
  );

  let fondleslab_screen = document.getElementById( fondleslab_screen_id );
  
  fondleslab_screen.classList.replace(
    'fondleslab-screen-enter-to',
    'fondleslab-screen-leave-to'
  );

}

/******************************************************************************/
