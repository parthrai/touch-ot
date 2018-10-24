<template>
  <div class="exhibitor-map-container">

    <div class="exhibitor-map-left-col">
      <section>
        <div
          v-for=" stand_type in stand_types "
          :key=" stand_type "
        >
          <button>{{ stand_type }}</button>
        </div>
      </section>
      <section>
        <div
          v-for=" stand_type in stand_types "
          :key=" stand_type "
          :id=" 'expo_list_' + stand_type "
          class="exhibitor-map-list exhibitor-map-list-hidden"
        >
          <div
            v-for=" stand in stands "
            :key=" stand.counter "
          >
            <div v-if=" stand.type == stand_type ">
              <div>exhibitor: {{ stand.exhibitor }}</div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <div class="exhibitor-map-right-col">

      <div class="exhibitor-map-container">
        <img
          :src=" currentMap "
          class="img-responsive exhibitor-map"
        >
        <img
          id="expo_stands_blackspot"
          class="exhibitor-blackspot"
          src="/images/touchscreen/expo-maps/blackspot.png"
        >
      </div>

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
      'scheduleFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          stand_types: [],
          stands: [],
          currentMap: null
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      getStands: function ()
      {
        let vueInstance = this;
        axios.get(
          '/api/touch-screen/get-expo-stands/' + vueInstance.eventInstanceName
        )
        .then(
          function ( response )
          {

            vueInstance.stands = [];

            for( var i = 0 ; i < response.data.length ; i++ )
            {

              let stand       = response.data[i];
              let standStruct = {
                counter:      i,
                type:         stand.type,
                exhibitor:    stand.exhibitor,
                stand:        stand.stand,
                position_x:   stand.position_x,
                position_y:   stand.position_y,
                map_image_lg: stand.map_image_lg,
                map_image_md: stand.map_image_md,
                map_image_sm: stand.map_image_sm,
                map_image_xs: stand.map_image_xs
              };

              if( vueInstance.stand_types.indexOf( stand.type ) == -1 )
              {
                vueInstance.stand_types.push( stand.type );
              }

              vueInstance.stands.push( standStruct );

              //vueInstance.$set( vueInstance.stands, i, standStruct );

            }

            console.log( "stands:", vueInstance.stands );

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
        let vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.getStands();
          },
          vueInstance.scheduleFrequencyMs
        );
      }
      /** ------------------------------------------------------------------ **/
    },
    /** -------------------------------------------------------------------- **/
    created: function ()
    {
      let vueInstance = this;
    },
    /** -------------------------------------------------------------------- **/
    mounted: function ()
    {
      let vueInstance = this;
      vueInstance.getStands();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss">

  @import '~@/_opentext-branding.scss';

  .exhibitor-map-container
  {

    display:grid;
    grid-template-columns:25% 75%;
    font-size:1vw;
    line-height:1.5vw;
    margin:0vw 0vh 0vw 0vh;
    width:100vw;
    height:100vh;
    background-color:green;

    .exhibitor-map-left-col
    {
      grid-column:1;
      grid-row:1;
      background-color:orange;
      overflow-x:hidden;
      overflow-y:scroll;

      .exhibitor-map-list
      {
        &-hidden
        {
          display:none;
        }
      }

    }

    .exhibitor-map-right-col
    {

      grid-column:2;
      grid-row:1;
      background-color:royalblue;

      .exhibitor-map-container
      {
        position:relative;
        .exhibitor-map
        {
          position:relative;
          border-style:dotted;
          border-width:4px;
          border-color:#000000;
        }
        .exhibitor-blackspot
        {
          position:absolute;
          top:0px;
          left:0px;
        }
      }

    }

  }

</style>
