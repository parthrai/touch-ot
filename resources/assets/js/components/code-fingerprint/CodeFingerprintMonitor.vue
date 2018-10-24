<template>
  <div
    v-if=" debug === true "
    class="code-fingerprint-monitor"
  >
    <div>
      FINGERPRINT:
      currentFingerprint:{{ currentFingerprint }}
      ::
      newFingerprint:{{ newFingerprint }}
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
      'screenType',
      'currentFingerprint',
      'scheduleFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          newFingerprint: null
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      loadInitialVersion: function ()
      {
        const vueInstance            = this;
        vueInstance.newFingerprint = vueInstance.currentFingerprint;
      },
      /** ------------------------------------------------------------------ **/
      unleashWatchDog: function ()
      {

        const vueInstance = this;
        
        if( vueInstance.debug ) console.log( "FINGERPRINT:", "unleashWatchDog" );

        axios.get(
          '/code-fingerprint/current/' + vueInstance.eventInstanceName + '/' + vueInstance.screenType
        )
        .then(
          function ( response )
          {
            
            let payload = response.data;

            if( vueInstance.debug ) console.log( "FINGERPRINT:", "PAYLOAD", payload );

            if( vueInstance.debug ) console.log( "FINGERPRINT:", "WATCHDOG", vueInstance.currentFingerprint, vueInstance.newFingerprint );

            vueInstance.newFingerprint = payload;

            if( vueInstance.currentFingerprint != vueInstance.newFingerprint )
            {
              console.log( "RELOADING:", vueInstance.screenType );
              window.location.reload( true );
            }

          }
        )
        .catch(
          function ( error )
          {
            console.log( "FINGERPRINT:", error );
          }
        )
        .then(
          function ()
          {
            vueInstance.scheduleWatchDog();
          }
        );

      },
      /** ------------------------------------------------------------------ **/
      scheduleWatchDog: function ()
      {
        const vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.unleashWatchDog();
          },
          vueInstance.scheduleFrequencyMs
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
      if( vueInstance.debug ) console.log( "FINGERPRINT:", "LOADED" );
      vueInstance.loadInitialVersion();
      vueInstance.unleashWatchDog();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .code-fingerprint-monitor
  {
    display:block;
    position:absolute;
    bottom:0px;
    left:0px;
    z-index:10;
    font-weight:bold;
    color:#FFFFFF;
    background-color:#FF0000;
    padding:5px 10px 5px 10px;
  }

</style>
