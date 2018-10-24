/**
 *
 *  This is used by the users admin screen to toggle admin status of user.
 *
 */

window.otUserToggleAdmin = {
  reqListener: function ()
  {
    console.log( this.responseText );
  },
  add_admin: function ( id )
  {
    let oReq = new XMLHttpRequest();
    if( oReq.addEventListener )
    {
      oReq.addEventListener( "load", otUserToggleAdmin.reqListener, false );
    }
    else if ( oReq.attachEvent )
    {
      oReq.addEventListener( "onload", otUserToggleAdmin.reqListener );
    }
    oReq.open("GET", "/user/" + id + "/admin");
    oReq.send();
  },
  rm_admin: function( id )
  {
    let oReq = new XMLHttpRequest();
    oReq.addEventListener( "load", otUserToggleAdmin.reqListener );
    oReq.open( "GET", "/user/" + id + "/admin/destroy" );
    oReq.send();
  }
};
