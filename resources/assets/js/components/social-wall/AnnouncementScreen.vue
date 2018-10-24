<template>
  <div class="announcement-container">
    <h1 v-if=" message ">{{ message }}</h1>
  </div>
</template>

<script>
  export default
  {
    props: [
      'debug',
      'eventInstanceName',
      'scheduleFrequencyMs'
    ],
    data: function ()
    {
      return(
        {
          message: null
        }
      );
    },
    methods: {
      /** ------------------------------------------------------------------ **/
      getAnnouncement: function ()
      {
        const vueInstance = this;
        axios.get(
          '/api/announcements/get-announcement/' + vueInstance.eventInstanceName,
          {
            params: {
            }
          }
        )
        .then(
          function ( response )
          {
            let announcement = response.data;
            if( vueInstance.debug === true ) console.log( "announcement:", announcement );
            vueInstance.message = announcement.announcement;
          }
        )
        .catch(
          function ( error )
          {
            console.log( error );
          }
        )
        .then(
          function ()
          {
            vueInstance.scheduleFetch();
          }
        );
      },
      /** ------------------------------------------------------------------ **/
      scheduleFetch: function ()
      {
        const vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.getAnnouncement();
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
      vueInstance.getAnnouncement();
    },
    /** -------------------------------------------------------------------- **/
    mounted: function ()
    {
      const vueInstance = this;
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .announcement-container
  {
    position:absolute;
    width:100vw;
    height:100vh;
    padding:0vh 5vw 0vh 5vw;
    margin:auto 0vw auto 0vw;
    h1
    {
      position:relative;
      top:45%;
      transform:translateY( -60% );
      font-size:5vw;
      line-height:7vw;
      font-weight:bold;
      color:$ot_white;
      text-align:center;
      width:100%;
      padding:2vh 2vw 3vh 2vw;
      margin:0vh auto 0vh auto;
      background-color:$ot_red;
    }
  }

</style>
