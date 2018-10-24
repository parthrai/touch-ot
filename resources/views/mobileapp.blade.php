<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

    <!-- App CSS -->
    <style type="text/css">
    html {
      height: 100%;
    }

    body {
      color: #FFF;
      background-color: #111B58;
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
      font-family: "aktiv-grotesk", "helvetica-neue", Helvetica, Arial, sans-serif;
      text-align: center;
    }

    .container-fluid {
      padding-top: 30px;
      padding-bottom: 30px;
      width: 70%;
      height: 100%;
    }
    @media only screen and (max-width: 767px) {
      .container-fluid {
        width: 80%;
      }
    }

    .container-fluid > .row {
      height: 100%;
      -ms-flex-align: center !important;
      align-items: center !important;
    }
    @media only screen and (max-width: 767px) and (orientation: landscape) {
      .container-fluid > .row {
        height: auto;
        -ms-flex-align: auto !important;
        align-items: auto !important;
      }
    }

    #logo {
      margin-bottom: 38px;
    }
    @media only screen and (max-width: 767px) {
      #logo {
        width: 71%;
      }
    }

    #appIcon {
      width: 31.5%;
      margin-bottom: 38px;
    }
    @media only screen and (max-width: 767px) {
      #appIcon {
        width: 60%;
        margin-bottom: 40px;
      }
    }

    #heading {
      font-size: 30px;
      font-weight: 700;
      margin-bottom: 40px;
    }
    @media only screen and (max-width: 767px) {
      #heading {
        font-size: 1.2em;
        margin-bottom: 30px;
      }
    }

    @media only screen and (max-width: 767px) and (orientation: landscape) {
      #badges .col-md-3 {
        width: 40%;
      }
    }
    .storeBadge {
      margin-bottom: 15px;
    }
    @media only screen and (max-width: 767px) {
      .storeBadge {
        width: 80%;
      }
    }

    /*# sourceMappingURL=style.css.map */

    </style>

    <title>Enterprise World 2018 Mobile App</title>

    <!-- Tyepkit -->
    <script src="https://use.typekit.net/oae8zyf.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>


    <script>

        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-56000503-9', 'auto');
        ga('send', 'pageview');

        function getMobileOperatingSystem() {
            var userAgent = navigator.userAgent || navigator.vendor || window.opera;
            if(userAgent.match( /iPad/i ) || userAgent.match( /iPhone/i ) || userAgent.match( /iPod/i )) {

                //track event
                ga('send', 'event', 'pageload', 'redirect', 'iOS App Store');
                //redirect
                setTimeout(function(){ window.location = 'https://itunes.apple.com/us/app/opentext-enterprise-world/id1225869919?ls=1&mt=8'; }, 1000);

            } else if(userAgent.match( /Android/i )){

                //track event
                ga('send', 'event', 'pageload', 'redirect', 'Google Play Store');
                //redirect
                setTimeout(function(){ window.location = 'https://play.google.com/store/apps/details?id=com.opentext.android.ew2017'; }, 1000);

            } else {

                ga('send', 'event', 'pageload', 'redirect', 'No Redirect');
                //do nothing

            }
        }

        getMobileOperatingSystem();

    </script>

  </head>
  <body>

    <div class="container-fluid">
      <div class="row">
        <div class="col">

          <div class="row">
            <div class="col-sm">
              <img id="logo" src="http://otew.io/images/mobileapp/logo.svg" alt="OpenText Enterprise World 2018" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <img id="appIcon" src="http://otew.io/images/mobileapp/app-icon.png" alt="" id="appIcon" />
            </div>
          </div>

          <div class="row">
            <div class="col-sm">
              <h1 id="heading">Download the OpenText Enterprise World  2018 Mobile&nbsp;App</h1>
            </div>
          </div>

          <div class="row justify-content-center" id="badges">
            <div class="col-md-3">
              <a href="https://itunes.apple.com/us/app/opentext-enterprise-world/id1225869919?ls=1&mt=8"><img src="http://otew.io//images/mobileapp/appstore-badge.png" alt="Get it on iOS" class="img-fluid storeBadge"/></a>
            </div>
            <div class="col-md-3">
              <a href="https://play.google.com/store/apps/details?id=com.opentext.android.ew2017"><img src="http://otew.io//images/mobileapp/google-play-badge.png" alt="Get it on iOS" class="img-fluid storeBadge"/></a>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  </body>
</html>
