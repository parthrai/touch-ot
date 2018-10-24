<template>
  <div class="scoreboard-team-container">

    <div>

      <div
        class="scoreboard-team"
        v-for=" team in teamScores "
        :key="team.id"
      >

        <span
          class="scoreboard-team-counter"
        >{{ team.counter + 1 }}.</span>

        <span
          class="scoreboard-team-badge"
          v-if=" team.team_name "
        >
          <team-badge
            canvas-class=""
            v-bind:team-name=" team.team_name "
            v-bind:badge-label=" '#' + team.team_hashtag "
            v-bind:badge-width=" 500 "
            v-bind:badge-height=" 500 "
            v-bind:badge-background-color=" team.team_background_color "
            v-bind:badge-text-color=" team.team_text_color "
          ></team-badge>
        </span>

        <span
          class="scoreboard-team-name"
        >Team {{ team.team_display_name }}</span>

        <span
          class="scoreboard-team-points"
        >{{ team.points_aggregate }}</span>

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
          teamScores: []
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      getScores: function ()
      {
        const vueInstance = this;
        axios.get(
          '/api/scoreboard/get-team-scores/' + vueInstance.eventInstanceName
        )
        .then(
          function ( response )
          {

            for( var i = 0 ; i < response.data.length ; i++ )
            {

              let team = response.data[i];

              let teamStruct = {
                counter: i,
                team_name: team.team_name,
                team_display_name: team.team_display_name,
                team_hashtag: team.team_hashtag,
                team_background_color: team.team_background_color,
                team_text_color: team.team_text_color,
                points: window.NumberWithCommas( team.points ),
                points_aggregate: window.NumberWithCommas( team.points_aggregate )
              };

              vueInstance.$set( vueInstance.teamScores, i, teamStruct );

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
            vueInstance.getScores();
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
      vueInstance.getScores();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss">

  @import '~@/_opentext-branding.scss';

  .scoreboard-team-container
  {
    font-size:4vw;
    line-height:6vw;
    margin:2vw 5% 0vw 5%;
  }

  .scoreboard-team
  {
    display:grid;
    grid-template-columns:8% 20% auto auto;
    height:7vw;
    margin:0pt 0pt 1vw 0pt;
    padding:0% 0% 0% 0%;
    background-color:rgba(245,245,245,0.8);
  }

  .scoreboard-team-counter
  {
    grid-column:1;
    grid-row:1;
    font-weight:bold;
    text-align:right;
    margin:0% 0% 0% 0%;
  }

  .scoreboard-team-badge
  {
    grid-column:2;
    grid-row:1;
    margin:0.75vw auto 0% auto;
  }

  .scoreboard-team-badge canvas
  {
    width:5vw;
    height:5vw;
    display:inline-block;
    vertical-align:baseline;
  }

  .scoreboard-team-name
  {
    grid-column:3;
    grid-row:1;
  }

  .scoreboard-team-points
  {
    grid-column:4;
    grid-row:1;
    font-weight:bold;
    text-align:right;
    margin:0% 5vh 0% 0%;
  }

</style>
