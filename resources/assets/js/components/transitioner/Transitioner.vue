<template>
  <div class="transitioner-container">
    <div
      v-for=" slot in this.$slots "
      :key=" slot.id "
    >
      <slot></slot>
    </div>
  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'debug',
      'eventInstanceName',
      'settingsFrequencyMs',
      'transitionFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          settings: [],
          activeSlides: [],
          currentSlide: 0
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      configureLayout: function ()
      {

        const vueInstance = this;
        var slides      = vueInstance.$el.querySelectorAll( '.item' );
        var z           = slides.length + 100;

        vueInstance.getSettings(
          function ()
          {
            vueInstance.doTransition();
          }
        );

        for( var slide = 0 ; slide < slides.length ; slide++ )
        {

          slides[slide].zIndex = z;

          if( slide == 0 )
          {
            slides[slide].classList.remove( 'item-hidden' );
            slides[slide].classList.add( 'item-show' );
          }
          else
          {
            slides[slide].classList.remove( 'item-show' );
            slides[slide].classList.add( 'item-hidden' );
          }

          z--;

        }

      },
      /** ------------------------------------------------------------------ **/
      getSettings: function ( callback )
      {
        const vueInstance = this;
        axios.get(
          '/api/monitor/social-wall/settings/' + vueInstance.eventInstanceName
        )
        .then(
          function ( response )
          {
            
            let payload = response.data;
            
            if( vueInstance.debug ) console.log( "payload:", payload );

            for( let setting in payload )
            {

              let enabled  = payload[setting].enabled;
              let duration = payload[setting].duration;

              vueInstance.settings[setting] = {
                enabled: enabled,
                duration: duration
              };

            }

            if( vueInstance.debug ) console.log( "vueInstance.settings:", vueInstance.settings );

          }
        )
        .catch(
          function ( error )
          {
            console.log( "Transitioner:", error );
          }
        )
        .then(
          function ()
          {

            vueInstance.scheduleSettingsCycle();

            if( ( callback !== null ) && ( typeof( callback ) == "function" ) )
            {
              if( vueInstance.debug ) console.log( "getSettings:", "calling callback" );
              callback();
            }
            else
            {
              if( vueInstance.debug ) console.log( "getSettings:", "callback missing" );
            }

          }
        );
      },
      /** ------------------------------------------------------------------ **/
      scheduleSettingsCycle: function ()
      {
        const vueInstance = this;
        console.log( "Transitioner: ", "scheduleSettingsCycle" );
        setTimeout(
          function ()
          {
            vueInstance.getSettings(
              function ()
              {
                if( vueInstance.debug ) console.log( "NO-OP" );
              }
            );
          },
          vueInstance.settingsFrequencyMs
        );
      },
      /** ------------------------------------------------------------------ **/
      doTransition: function ()
      {

        const vueInstance = this;
        var slides        = vueInstance.$el.querySelectorAll( '.item' );
        var found         = false;
        var currentSlide  = vueInstance.currentSlide;
        var nextSlide     = currentSlide;
        var duration      = 5000;

        if( vueInstance.debug ) console.log( "doTransition" );

        try
        {

          do
          {

            nextSlide++;

            if( nextSlide >= slides.length )
            {
              nextSlide = 0;
            }

            if( nextSlide == currentSlide )
            {
              if( vueInstance.debug ) console.log( "BREAK: Only one slide!" );
              break;
            }
            else
            {

              let screenName = slides[nextSlide].dataset.screenName;
              
              if( vueInstance.settings[screenName] !== null )
              {
                if( vueInstance.settings[screenName].enabled === true )
                {
                  duration = vueInstance.settings[screenName].duration;
                  found = true;
                  break;
                }
              }

            }

          }
          while( ! found );

          vueInstance.currentSlide = nextSlide;

          if( slides[currentSlide].classList.contains( 'item-show' ) )
          {
            slides[currentSlide].classList.replace( 'item-show', 'item-hidden' );
          }
          else
          {
            slides[currentSlide].classList.add( 'item-hidden' );
          }

          if( slides[nextSlide].classList.contains( 'item-hidden') )
          {
            slides[nextSlide].classList.replace( 'item-hidden', 'item-show' );
          }
          else
          {
            slides[nextSlide].classList.add( 'item-show' );
          }

        }
        catch( ex )
        {
          console.log( ex );
        }

        vueInstance.scheduleTransitionCycle( duration );

      },
      /** ------------------------------------------------------------------ **/
      scheduleTransitionCycle: function ( duration )
      {

        const vueInstance = this;
        var wait          = 10000;

        if( vueInstance.debug ) console.log( "scheduleTransitionCycle:", duration );

        if( duration >= 0 )
        {
          wait = duration;
        }
        else
        {
          wait = vueInstance.transitionFrequencyMs;
        }

        if( vueInstance.debug ) console.log( "Next transition in " + wait + " seconds." );

        setTimeout(
          function ()
          {
            vueInstance.doTransition();
          },
          wait
        );

      }
      /** ------------------------------------------------------------------ **/
    },
    /** -------------------------------------------------------------------- **/
    created: function ()
    {
      const vueInstance = this;
    },
    /** -------------------------------------------------------------------- **/
    mounted: function ()
    {
      const vueInstance = this;
      vueInstance.configureLayout();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .transitioner-container
  {

    position:fixed;
    top:10vh;
    left:0px;
    width:100vw;
    height:90vh;
    margin:0vh 0vw 0vh 0vw;

    .item
    {

      position:absolute;
      top:0px;
      left:0px;

      width:100%;
      height:100%;

      opacity:0;
      transform:scale( 0.5, 0.5 );
      transition-property:opacity, transform;
      transition-duration:2.0s;
      transition-timing-function:ease;

    }

    .item-show
    {
      opacity:1;
      transform:scale( 1.0, 1.0 );
    }

    .item-hidden
    {
      opacity:0;
      transform:scale( 2.0, 2.0 );
    }

  }

</style>
