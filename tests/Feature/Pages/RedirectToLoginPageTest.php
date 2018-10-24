<?php

namespace Tests\Feature;

class RedirectToLoginPageTest extends DatabaseTestCase
{

  /****************************************************************************/

  /**
   * Test that home page is a 302 redirect.
   *
   * @return void
   */
  public function test_redirect_to_login_page ()
  {

    $response = $this->get( '/' );

    $response->assertStatus( 302 );

  }

  /****************************************************************************/

}
