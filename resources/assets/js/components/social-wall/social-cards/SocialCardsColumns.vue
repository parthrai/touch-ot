<template>
  <div class="social-cards-container">

    <!-- BEGIN: OUTER COLUMNS ********************************************** -->
    <div class="outer-columns">

      <!-- BEGIN: Featured Cards List ************************************** -->
      <div
        v-for=" card in cards_featured "
        :key="card.card_vue_id"
      >
        <strong v-if=" debug == true ">{{ card.card_vue_id }}</strong>
        <div v-if=" card.card_type === 'tweet' ">
          <social-card-tweet
            :debug=" debug "
            :card=" card "
          ></social-card-tweet>
        </div>
        <div v-else-if=" card.card_type === 'appworks_post' ">
          <social-card-appworks-post
            :debug=" debug "
            :card=" card "
          ></social-card-appworks-post>
        </div>
        <div v-else>
        </div>
      </div>
      <!-- END: Featured Cards List **************************************** -->

      <!-- BEGIN: INNER COLUMNS ******************************************** -->
      <div class="inner-columns">

        <!-- BEGIN: Cards List ********************************************* -->
        <div
          v-for=" card in cards "
          :key="card.card_vue_id"
        >
          <strong v-if=" debug == true ">{{ card.card_vue_id }}</strong>
          <div v-if=" card.card_type === 'tweet' ">
            <social-card-tweet
              :debug=" debug "
              :card=" card "
            ></social-card-tweet>
          </div>
          <div v-else-if=" card.card_type === 'appworks_post' ">
            <social-card-appworks-post
              :debug=" debug "
              :card=" card "
            ></social-card-appworks-post>
          </div>
          <div v-else>
          </div>
        </div>
        <!-- END: Cards List *********************************************** -->

      </div>
      <!-- END: INNER COLUMNS ********************************************** -->

    </div>
    <!-- END: OUTER COLUMNS ************************************************ -->

  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'debug',
      'eventInstanceName',
      'maxCards',
      'maxFeaturedCards',
      'scheduleFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          cards: [],          // Set of cards to display
          cards_featured: [], // Set of featured cards to display
          seen: []            // History of seen cards
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    watch:
    {
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      getCards: function ()
      {

        const vueInstance = this;

        axios.post(
          '/api/social-cards/get-cards/' + vueInstance.eventInstanceName,
          {
            max_items: vueInstance.maxCards,
            current_cards: {
              cards: vueInstance.cards,
              cards_featured: vueInstance.cards_featured
            }
          }
        )
        .then(
          function ( response )
          {

            /** BEGIN: Deleted Cards --------------------------------------- **/
            for( let card_id of response.data.delete_cards )
            {

              try
              {
                if( vueInstance.debug == true ) console.log( "Delete Cards FEATURED 1:", vueInstance.cards_featured.length );
                let index_featured = vueInstance.cards_featured.findIndex(
                  function ( element )
                  {
                    return element.card_vue_id == card_id;
                  }
                );
                if( index_featured >= 0  )
                {
                  vueInstance.cards_featured.splice( index_featured, 1 );
                }
                if( vueInstance.debug == true ) console.log( "Delete Cards FEATURED 2:", vueInstance.cards_featured.length );
              }
              catch( ex )
              {
                if( vueInstance.debug == true ) console.log( "EXCEPTION Delete Cards FEATURED:", ex.message );
              }

              try
              {
                if( vueInstance.debug == true ) console.log( "Delete Cards NORMAL 1:", vueInstance.cards.length );
                let index_featured = vueInstance.cards.findIndex(
                  function ( element )
                  {
                    return element.card_vue_id == card_id;
                  }
                );
                if( index_featured >= 0  )
                {
                  vueInstance.cards.splice( index_featured, 1 );
                }
                if( vueInstance.debug == true ) console.log( "Delete Cards NORMAL 2:", vueInstance.cards.length );
              }
              catch( ex )
              {
                if( vueInstance.debug == true ) console.log( "EXCEPTION Delete Cards FEATURED:", ex.message );
              }

              try
              {
                if( vueInstance.debug == true ) console.log( "Delete Cards SEEN 1:", vueInstance.seen.length );
                let index_seen = vueInstance.seen.findIndex(
                  function ( element )
                  {
                    return element == card_id;
                  }
                );
                if( index_seen >= 0  )
                {
                  vueInstance.seen.splice( index_seen, 1 );
                }
                if( vueInstance.debug == true ) console.log( "Delete Cards SEEN 2:", vueInstance.seen.length );
              }
              catch( ex )
              {
                if( vueInstance.debug == true ) console.log( "EXCEPTION Delete Cards SEEN:", ex.message );
              }

            }
            /** END: Deleted Cards ----------------------------------------- **/

            /** BEGIN: Remove Cards ---------------------------------------- **/
            for( let card of response.data.remove_cards )
            {

              try
              {
                if( vueInstance.debug == true ) console.log( "Remove Cards FEATURED 1:", vueInstance.cards_featured.length );
                let index_featured = vueInstance.cards_featured.findIndex(
                  function ( element )
                  {
                    return element.card_vue_id == card.card_vue_id;
                  }
                );
                if( index_featured >= 0  )
                {
                  vueInstance.cards_featured.splice( index_featured, 1 );
                }
                if( vueInstance.debug == true ) console.log( "Remove Cards FEATURED 2:", vueInstance.cards_featured.length );
              }
              catch( ex )
              {
                if( vueInstance.debug == true ) console.log( "EXCEPTION Remove Cards FEATURED:", ex.message );
              }

              try
              {
                if( vueInstance.debug == true ) console.log( "Remove Cards NORMAL 1:", vueInstance.cards.length );
                let index_featured = vueInstance.cards.findIndex(
                  function ( element )
                  {
                    return element.card_vue_id == card.card_vue_id;
                  }
                );
                if( index_featured >= 0  )
                {
                  vueInstance.cards.splice( index_featured, 1 );
                }
                if( vueInstance.debug == true ) console.log( "Remove Cards NORMAL 2:", vueInstance.cards.length );
              }
              catch( ex )
              {
                if( vueInstance.debug == true ) console.log( "EXCEPTION Remove Cards FEATURED:", ex.message );
              }

              try
              {
                if( vueInstance.debug == true ) console.log( "Remove Cards SEEN 1:", vueInstance.seen.length );
                let index_seen = vueInstance.seen.findIndex(
                  function ( element )
                  {
                    return element == card.card_vue_id;
                  }
                );
                if( index_seen >= 0  )
                {
                  vueInstance.seen.splice( index_seen, 1 );
                }
                if( vueInstance.debug == true ) console.log( "Remove Cards SEEN 2:", vueInstance.seen.length );
              }
              catch( ex )
              {
                if( vueInstance.debug == true ) console.log( "EXCEPTION Remove Cards SEEN:", ex.message );
              }

            }
            /** END: Remove Cards ------------------------------------------ **/

            /** BEGIN: Add Cards ------------------------------------------- **/
            for( let card of response.data.add_cards )
            {

              let index_seen = vueInstance.seen.findIndex(
                function ( element )
                {
                  return element == card.card_vue_id;
                }
              );

              if( index_seen < 0 )
              {
                
                if( vueInstance.debug == true ) console.log( "NEW:", card.card_vue_id );

                vueInstance.seen.push( card.card_vue_id );
                
                if( card.featured === true )
                {
                  if( vueInstance.cards_featured.length >= vueInstance.maxFeaturedCards )
                  {
                    vueInstance.cards_featured.pop();
                  }
                  vueInstance.cards_featured.unshift( card );
                }
                else
                {
                  if( vueInstance.cards.length >= vueInstance.maxCards )
                  {
                    vueInstance.cards.pop();
                  }
                  vueInstance.cards.unshift( card );
                }

              }
              else
              {
                if( vueInstance.debug == true ) console.log( "DUPLICATE:", card.card_vue_id );
              }

            }
            /** END: Add Cards --------------------------------------------- **/

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
            vueInstance.getCards();
          },
          vueInstance.scheduleFrequencyMs
        );
      },
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
      vueInstance.getCards();
    },
    /** -------------------------------------------------------------------- **/
    beforeDestroy: function ()
    {
      const vueInstance = this;
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  /** MEDIA QUERIES SET COLUMNS ***********************************************/

  .outer-columns
  {
    column-count:4;
    /*background-color:red;*/
  }

  .inner-columns
  {
    column-count:2;
    /*background-color:yellow;*/
  }

  @media ( min-width:10px )
  {
    .outer-columns
    {
      column-count:1;
    }
    .inner-columns
    {
      column-count:1;
    }
  }

  @media ( min-width:400px )
  {
    .outer-columns
    {
      column-count:1;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  @media ( min-width:600px )
  {
    .outer-columns
    {
      column-count:1;
    }
    .inner-columns
    {
      column-count:3;
    }
  }

  @media ( min-width:800px )
  {
    .outer-columns
    {
      column-count:2;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  @media ( min-width:1024px )
  {
    .outer-columns
    {
      column-count:3;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  @media ( min-width:1280px )
  {
    .outer-columns
    {
      column-count:4;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  @media ( min-width:1920px )
  {
    .outer-columns
    {
      column-count:5;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  @media ( min-width:3840px )
  {
    .outer-columns
    {
      column-count:6;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  @media ( min-width:4096px )
  {
    .outer-columns
    {
      column-count:8;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  @media ( min-width:7680px )
  {
    .outer-columns
    {
      column-count:10;
    }
    .inner-columns
    {
      column-count:2;
    }
  }

  /****************************************************************************/

  .social-cards-container
  {
    margin:0vh 0.5vw 0vh 0.5vw;
  }

  /****************************************************************************/

</style>
