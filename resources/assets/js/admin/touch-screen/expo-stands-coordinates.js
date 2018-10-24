/******************************************************************************/

window.InitExpoMapCoordPicker = function ( expo_stands_coordinates_picker, expo_stands_blackspot )
{

  document.getElementById( expo_stands_coordinates_picker ).addEventListener(
    "click",
    function ( ev )
    {

      document.getElementById( expo_stands_coordinates_picker ).addEventListener(
        "click",
        function ( ev )
        {

          let el = ev.target;

          // Find relative width and height of map:
          let el_width  = el.offsetWidth; 
          let el_height = el.offsetHeight;

          // Find coordinates of click relative to map element:
          let click_x = ev.offsetX;
          let click_y = ev.offsetY;

          // Calculate position X and Y coordinates:
          let percent_x = ( ( 100 / el_width ) * click_x ).toFixed( 4 );
          let percent_y = ( ( 100 / el_height ) * click_y ).toFixed( 4 );

          if( percent_x < 0 ) percent_x = 0;
          if( percent_x > 100 ) percent_x = 100;
          if( percent_y < 0 ) percent_y = 0;
          if( percent_y > 100 ) percent_y = 100;
                            
          let field_position_x   = document.getElementById( 'position_x' );
          let field_position_y   = document.getElementById( 'position_y' );
          field_position_x.value = percent_x;
          field_position_y.value = percent_y;

          window.ExpoMapCoordPickerPositionBlackspot(
            expo_stands_coordinates_picker,
            expo_stands_blackspot,
            percent_x,
            percent_y
          );

        }
      );

    }
  );

}

/******************************************************************************/

window.ExpoMapCoordPickerPositionBlackspot = function ( expo_map_element, blackspot_element, percent_x, percent_y )
{

  let el               = document.getElementById( expo_map_element );
  let blackspot        = document.getElementById( blackspot_element );
  let el_width         = el.offsetWidth;
  let el_height        = el.offsetHeight;
  let blackspot_x      = ( ( el_width / 100 ) * percent_x ).toFixed( 4 );
  let blackspot_y      = ( ( el_height / 100 ) * percent_y ).toFixed( 4 );

  blackspot.style.left = blackspot_x + 'px';
  blackspot.style.top  = blackspot_y + 'px';

}

/******************************************************************************/

window.ExpoMapCoordSetupImage = function ()
{

  let map_image_el = document.getElementById( 'expo_stands_coordinates_picker' );
  let blackspot_el = document.getElementById( 'expo_stands_blackspot' );

  if( ( map_image_el !== null ) && ( map_image_el.getAttribute('src').length > 0 ) )
  {
    map_image_el.style.display = "inline-block";
    blackspot_el.style.display = "inline-block";
  }
  else
  {
    map_image_el.style.display = "none";
    blackspot_el.style.display = "none";
  }

}

/******************************************************************************/

window.ExpoMapCoordMapSelect = function ( expo_map_list )
{

  let expo_map_id_el = document.getElementById( 'expo_map_id' );

  expo_map_id_el.addEventListener(
    "change",
    function ( ev )
    {

      let map_index    = ev.target.value;
      let map_uri      = '/storage/' + expo_map_list[map_index];
      let map_image_el = document.getElementById( 'expo_stands_coordinates_picker' );
      let blackspot_el = document.getElementById( 'expo_stands_blackspot' );

      if( ( map_index !== null ) && ( map_index > 0 ) )
      {
        map_image_el.src = map_uri;
        map_image_el.style.display = "inline-block";
        blackspot_el.style.display = "inline-block";
      }
      else
      {
        map_image_el.style.display = "none";
        blackspot_el.style.display = "none";
      }

    },
    { passive: true }
  );

}

/******************************************************************************/
