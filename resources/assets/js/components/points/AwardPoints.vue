<template>
  <div class="award-points-container">

    <template v-if=" awarded === false ">

      <template v-if=" teamName === null ">

        <template v-if=" awardType === null ">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h2 class="text-center">Award points to:</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="text-center">
                <button
                  class="btn btn-primary"
                  v-on:click=" setAwardType( 'individual' ) "
                >Individual</button>
              </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
              <div class="text-center">
                <button
                  class="btn btn-primary"
                  v-on:click=" setAwardType( 'team' ) "
                >Team</button>
              </div>
            </div>
          </div>
        </template>

        <template v-if=" awardType === 'individual' ">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h2 class="text-center">Enter the recipients full name:</h2>
            </div>
          </div>
          <div class="row">
            <div
              class="
                col-xs-6
                col-sm-6
                col-md-6
                col-lg-6
                col-xs-offset-3
                col-sm-offset-3
                col-md-offset-3
                col-lg-offset-3
              "
            >
              <input
                class="form-control"
                id="individualName"
                type="text"
                placeholder="Enter name"
              >
              <br>
              <div class="text-center">
                <button
                  class="btn btn-primary"
                  v-on:click=" setTeamName( $el.querySelector( '#individualName' ).value ) "
                >Next</button>
              </div>
            </div>
          </div>
        </template>
        <template v-else-if=" awardType === 'team' ">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <h2 class="text-center">Pick the team:</h2>
            </div>
          </div>
          <div
            class="row"
            v-for=" team in teams "
            :key=" team.id "
            v-on:click=" setTeamName( team.hashtag ) "
          >
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

              <div class="team-item">
                <div class="team-item-badge">
                  <team-badge
                    canvas-class=""
                    v-bind:team-name=" team.name "
                    v-bind:badge-label=" '#' + team.hashtag "
                    v-bind:badge-width=" 50 "
                    v-bind:badge-height=" 50 "
                    v-bind:badge-background-color=" team.hex_background_color "
                    v-bind:badge-text-color=" team.hex_text_color "
                  ></team-badge>
                </div>
                <div class="team-item-label">{{ team.display_name }}</div>
              </div>

            </div>
          </div>
        </template>
        <template v-else>
          <!-- NO-OP -->
        </template>

      </template>
      <template v-else>

        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2 class="text-center">Select a point denomination:</h2>
          </div>
        </div>
        <div
          class="row"
          v-for=" score in pointsList "
          :key=" score "
        >
          <div
            class="
              col-xs-12
              col-sm-12
              col-md-12
              col-lg-12
            "
          >
            <div
              class="score-item"
              v-bind:class="{ active: pointsSelected[score] }"
              v-on:click=" setScore( score ) "
            >{{ score }} Points</div>
          </div>
        </div>

      </template>

      <div class="row">
        <div
          v-if=" score !== null "
          class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
        >
          <div class="text-center">
            <button
              class="btn btn-danger"
              v-on:click=" resetAll() "
            >Reset</button>
          </div>
        </div>
        <div
          v-if=" score !== null "
          class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
        >
          <div class="text-center">
            <button
              class="btn btn-primary"
              v-on:click=" sendPoints() "
            >Award Points</button>
          </div>
        </div>
      </div>

    </template>
    <template v-else>

      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="text-center">
            <h2 class="text-center">Points awarded</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="text-center">
            <button
              class="btn btn-primary"
              v-on:click=" resetAll() "
            >Start over</button>
          </div>
        </div>
      </div>

    </template>

  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'eventInstanceName',
      'userId',
      'teams'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          awarded: false,
          awardType: null,
          teamName: null,
          score: null,
          pointsList: [
            200,
            500,
            1000,
            2500,
            5000
          ],
          pointsSelected: {
            200: false,
            500: false,
            1000: false,
            2500: false,
            5000: false
          }
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      resetAll: function ()
      {
        const vueInstance       = this;
        vueInstance.awarded   = false;
        vueInstance.awardType = null;
        vueInstance.teamName  = null;
        vueInstance.score     = null;
        for( let key in vueInstance.pointsSelected )
        {
          vueInstance.pointsSelected[key] = false;
        }
      },
      /** ------------------------------------------------------------------ **/
      setAwardType: function ( awardType )
      {
        const vueInstance       = this;
        vueInstance.awardType = awardType;
      },
      /** ------------------------------------------------------------------ **/
      setTeamName: function ( teamName )
      {
        const vueInstance      = this;
        if( teamName !== null )
        {
          if( teamName.length > 0 )
          {
            vueInstance.teamName = teamName;
          }
        }
      },
      /** ------------------------------------------------------------------ **/
      setScore: function ( score )
      {
        const vueInstance = this;
        vueInstance.score = score;
        for( let key in vueInstance.pointsSelected )
        {
          vueInstance.pointsSelected[key] = false;
        }
        vueInstance.pointsSelected[score] = true;
      },
      /** ------------------------------------------------------------------ **/
      sendPoints: function ()
      {
        const vueInstance = this;
        axios.post(
          '/api/points/postPoints/' + vueInstance.eventInstanceName,
          {
            user_id: vueInstance.userId,
            team: vueInstance.teamName,
            score: vueInstance.score
          }
        )
        .then(
          function ( response )
          {
            vueInstance.awarded = true;
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
          }
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
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_variables.scss';
  @import '~@/_opentext-branding.scss';

  .award-points-container
  {
    background-color:none;
  }

  h2
  {
    margin:10px 0px 50px 0px;
  }

  .form-control input[type="text"]
  {
    font-size:32px;
    height:50px;
  }

  button
  {
    font-size:24px;
    width:200px;
    padding:20px 20px 20px 20px;
    margin:20px 20px 50px 20px;
  }

  .team-item
  {
    font-size:32px;
    font-weight:bold;
    color:#000000;
    background-color:#EEEEEE;
    border-style:solid;
    border-width:1px;
    border-color:#888888;
    border-radius:10px;
    width:500px;
    margin:0px auto 20px auto;
    padding:10px 10px 10px 10px;
    cursor:pointer;
    &:hover
    {
      color:#FFFFFF;
      background-color:$brand-success;
    }
    .team-item-badge
    {
      display:inline-block;
      padding:10px 40px 0px 40px;
    }
    .team-item-label
    {
      display:inline-block;
    }
  }

  .score-item
  {
    font-size:32px;
    font-weight:bold;
    text-align:center;
    color:#000000;
    background-color:#FFFFFF;
    border-style:solid;
    border-width:1px;
    border-color:#888888;
    border-radius:10px;
    width:500px;
    margin:0px auto 20px auto;
    padding:20px 20px 20px 20px;
    cursor:pointer;
    &:hover
    {
      color:#FFFFFF;
      background-color:$brand-success;
    }
    &.active
    {
      color:#FFFFFF;
      background-color:$brand-success;
    }
  }

</style>
