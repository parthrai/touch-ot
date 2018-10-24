<template>
  <div class="row ts-wrapper">
    
    <header>
      <div class="row">
        <div class="col-lg-12 logo">
          <img src="images/touchscreen/opentext-ew-logo.png" alt="logo" height="60">
        </div>
      </div>
    </header>

    <transition
      name="router-anim"
      enter-active-class="animated fadeInDown"
      leave-active-class="animated fadeOutDown"
    >
      <router-view></router-view>
    </transition>

    <v-dialog
      v-model="showAreYouStillThere"
      hide-overlay
      persistent
      width="300"
    >
      <v-card color="white">
        <v-card-text>
          <h2>Are you still there ?</h2>
          <p>You will be redirect in {{ timeToRedirect }} seconds</p>
          <v-progress-linear
            indeterminate
            color="primary"
            class="mb-0"
          ></v-progress-linear>
          <v-btn
            class="white--text"
            color="purple darken-2"
            @click=" showAreYouStillThere = false "
          >
            Tap here to continue
          </v-btn>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default
  {
    data ()
    {
      return(
        {
          showAreYouStillThere: false,
          timeToRedirect: 10
        }
      );
    },
    methods:
    {
      timer: function ( i )
      {
        this.timeToRedirect = i;
      }
    },
    onIdle ()
    {
      if( this.$router.currentRoute.path != '/' )
      {
        this.showAreYouStillThere = true;
        for( let i = 1 ; i < 10 ; i++ )
        {
          setTimeout(
            function timer()
            {
              console.log( i );
              this.timeToRedirect = i;
              console.log( this.timeToRedirect );
            },
            i * 1000
          );
        }
      }
      console.log( 'idle idle' );
    },
    onActive ()
    {
      this.showAreYouStillThere = false;
      console.log( 'active state' );
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .ts-wrapper
  {
    
    position:relative;
    top:0px;
    background-image:url("http://otew.io/socialwall/img/ew-2018-background.png");
    background-size:cover;
    height:100%;

    .logo
    {
      position:relative;
      top:6vh;
      left:6vw;
    }

  }

</style>
