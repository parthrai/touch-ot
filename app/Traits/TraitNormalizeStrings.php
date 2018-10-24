<?php

namespace App\Traits;

trait TraitNormalizeStrings
{

  /****************************************************************************/
  
  /**
  * Normalize a string used to name and event instance.
  *
  * @param  string $value
  * @return string
  */
  public static function NormalizeEventInstanceName ( string $value )
  {

    $copy = $value;

    if( isset( $copy ) && ( strlen( $copy ) > 0 ) )
    {
      $copy = strtolower( $copy );                            // Downcase
      $copy = preg_replace( '/[^a-z0-9\-\s]+/i', '', $copy ); // Replace non-alphanumerics
      $copy = preg_replace( '/^[\s]+/', '', $copy );          // Strip leading white space
      $copy = preg_replace( '/[\s]+$/', '', $copy );          // Strip trailing white space
      $copy = preg_replace( '/[\s]+/', '-', $copy );          // Replace spaces with hyphens
      $copy = preg_replace( '/-+/', '-', $copy );             // Compact hyphens
      $copy = preg_replace( '/^[^a-z0-9\s]+/i', '', $copy );  // Replace non-alphanumerics at start
      $copy = preg_replace( '/[^a-z0-9\s]+$/i', '', $copy );  // Replace non-alphanumerics at end
    }

    return( $copy );

  }

  /****************************************************************************/
  
  /**
  * Normalize a string used to name an object.
  *
  * @param  string $value
  * @return string
  */
  public static function NormalizeObjectName ( string $value )
  {

    $copy = $value;

    if( isset( $copy ) && ( strlen( $copy ) > 0 ) )
    {
      $copy = strtolower( $copy );                            // Downcase
      $copy = preg_replace( '/[^a-z0-9\-\s]+/i', '', $copy ); // Replace non-alphanumerics
      $copy = preg_replace( '/^[\s]+/', '', $copy );          // Strip leading white space
      $copy = preg_replace( '/[\s]+$/', '', $copy );          // Strip trailing white space
      $copy = preg_replace( '/[\s]+/', '-', $copy );          // Replace spaces with hyphens
      $copy = preg_replace( '/-+/', '-', $copy );             // Compact hyphens
      $copy = preg_replace( '/^[^a-z0-9\s]+/i', '', $copy );  // Replace non-alphanumerics at start
      $copy = preg_replace( '/[^a-z0-9\s]+$/i', '', $copy );  // Replace non-alphanumerics at end
    }

    return( $copy );

  }

  /****************************************************************************/
  
  /**
  * Normalize a human-readable label string.
  *
  * @param  string $value
  * @return string
  */
  public static function NormalizeLabel ( string $value )
  {

    $copy = $value;

    if( isset( $copy ) && ( strlen( $copy ) > 0 ) )
    {
      $copy = preg_replace( '/^[\s]+/', '', $copy );          // Strip leading white space
      $copy = preg_replace( '/[\s]+$/', '', $copy );          // Strip trailing white space
      $copy = preg_replace( '/[\s]+/', ' ', $copy );          // Compact white space
    }

    return( $copy );

  }

  /****************************************************************************/

}
