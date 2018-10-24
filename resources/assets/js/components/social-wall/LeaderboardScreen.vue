<template>
  <div class="leaderboard-container">
    <div
      class="
        visible-xs
        hidden-sm
        hidden-md
        hidden-lg
      "
    >
      <img
        class="img-responsive image"
        :src=" imageXsUrl "
      >
    </div>
    <div
      class="
        hidden-xs
        visible-sm
        hidden-md
        hidden-lg
      "
    >
      <img
        class="img-responsive image"
        :src=" imageSmUrl "
      >
    </div>
    <div
      class="
        hidden-xs
        hidden-sm
        visible-md
        hidden-lg
      "
    >
      <img
        class="img-responsive image"
        :src=" imageMdUrl "
      >
    </div>
    <div
      class="
        hidden-xs
        hidden-sm
        hidden-md
        visible-lg
      "
    >
      <img
        class="img-responsive image"
        :src=" imageLgUrl "
      >
    </div>
  </div>
</template>

<script>
  export default
  {
    props: [
      'debug',
      'eventInstanceName',
      'screenOrder',
      'scheduleFrequencyMs'
    ],
    data: function ()
    {
      return(
        {
          imageXsUrl: null,
          imageSmUrl: null,
          imageMdUrl: null,
          imageLgUrl: null
        }
      );
    },
    methods: {
    /** ------------------------------------------------------------------ **/
      getImages: function ()
      {
        const vueInstance = this;
        axios.get(
          '/api/leaderboards/' + vueInstance.eventInstanceName,
          {
            params: {
            }
          }
        )
        .then(
          function ( response )
          {
            for( let leaderboard of response.data )
            {
              if( leaderboard.display_order === vueInstance.screenOrder )
              {
                vueInstance.imageXsUrl = leaderboard.image_xs;
                vueInstance.imageSmUrl = leaderboard.image_sm;
                vueInstance.imageMdUrl = leaderboard.image_md;
                vueInstance.imageLgUrl = leaderboard.image_lg;
                break;
              }
            }
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
            vueInstance.getImages();
          },
          vueInstance.scheduleFrequencyMs
        );
      }
      /** ------------------------------------------------------------------ **/
    },
    created: function ()
    {
      const vueInstance = this;
    },
    mounted: function ()
    {
      const vueInstance = this;
      vueInstance.getImages();
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .leaderboard-container
  {
    width:100%;
    height:80vh;
    margin-left:auto;
    margin-right:auto;
    .image
    {
      max-height:80vh;
      display:block;
      margin:auto auto auto auto;
      box-shadow: 0px 0px 10px rgba( 64, 64, 255, 0.4 );
    }
  }

</style>
