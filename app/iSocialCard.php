<?php

namespace App;

/*******************************************************************************

This interface allows any implementor of this interface to be passed to any
method that requires a class that implements this interface.

*******************************************************************************/

interface iSocialCard
{

  /** RELATIONSHIPS ***********************************************************/

  // NONE
  
  /** PUBLIC METHODS **********************************************************/

  public function SetApproved ( Bool $approved );
  public function GetApproved ();

  public function SetFeatured ( Bool $featured );
  public function GetFeatured ();

  public function AddHashtags ( $tags );
  public function GetHashtags ();

  /****************************************************************************/
  
}
