<template>
  <div class="which-team-container">

    <div class="which-team-left-col">

      <h1>Which team am I on?</h1>

      <p>Each person has been randomly assigned to a team; each team represents one of five colors.</p>

      <p>Your team color can be found on the border of your badge holder, and is already linked to your profile in the Enterprise World mobile app.</p>

    </div>

    <div class="which-team-right-col">

      <div class="which-team-list">

        <section
          class="which-team-badges"
          v-for=" team in teamScores "
          :key="team.id"
        >

          <span
            class="which-team-badge"
            v-if=" team.team_name "
          >
            <team-badge
              canvas-class="which-team-canvas"
              v-bind:team-name=" team.team_name "
              v-bind:badge-label=" '#' + team.team_hashtag "
              v-bind:badge-width=" 500 "
              v-bind:badge-height=" 500 "
              v-bind:badge-background-color=" team.team_background_color "
              v-bind:badge-text-color=" team.team_text_color "
            ></team-badge>
          </span>

          <span
            class="which-team-name"
          >Team {{ team.team_display_name }}</span>

        </section>

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

  .which-team-container
  {

    display:grid;
    grid-template-columns:40% 60%;
    font-size:4vw;
    line-height:6vw;
    margin:0vw 0vh 0vw 0vh;

    h1
    {
      font-size:3vw;
      font-weight:bold;
      color:$ot_blue;
      margin:10vh 0vw 20vh 5vw;
    }

    p
    {
      font-size:1.5vw;
      line-height:2vw;
      font-weight:bold;
      color:$ot_black;
      margin:0vh 0vw 5vh 5vw;
    }

    .which-team-left-col
    {
      grid-column:1;
      grid-row:1;
    }

    .which-team-right-col
    {
      grid-column:2;
      grid-row:1;
    }

    .which-team-list
    {
      margin:10vh 5vw 20vh 5vw;
      .which-team-badges
      {
        display:grid;
        grid-template-columns:20% auto;
        height:7vw;
        margin-bottom:2vh;
        .which-team-badge
        {
          grid-column:1;
          grid-row:1;
          margin:0.75vw auto 0% auto;
          canvas.which-team-canvas
          {
            width:5vw;
            height:5vw;
            display:inline-block;
            vertical-align:baseline;
          }
        }
        .which-team-name
        {
          grid-column:2;
          grid-row:1;
          color:$ot_grey;
        }
      }
    }

  }

</style>
