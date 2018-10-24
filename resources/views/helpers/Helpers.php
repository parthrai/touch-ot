<?php

/******************************************************************************/

function insert_zero_width_spaces_alphanumeric ( $value )
{

  $result = $value;

  if( isset( $value ) && (strlen( $value ) > 0 ) )
  {
    $result = preg_replace( "/([a-zA-Z0-9])/", '${1}&#8203;', $value  );
  }

  return( $result );

}

/******************************************************************************/
