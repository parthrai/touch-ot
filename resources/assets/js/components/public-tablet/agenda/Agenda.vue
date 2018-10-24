<template>
  <div class="main-content">
    <v-container grid-list-md>
      <v-layout row wrap>
        <v-flex>
          <v-card>

            <v-tabs
              v-model="active"
              slider-color="black"
            >

              <v-tab
                v-for=" day in agenda "
                :key=" day.vue_id "
                ripple
              >
                {{ day.tab_label }}
              </v-tab>

              <v-tab-item
                v-for=" day in agenda "
                :key=" day.vue_id "
              >

                <!-- BEGIN: IMAGE TAB ************************************** -->
                <template v-if=" day.type == 'image' ">
                  <v-card flat>
                    <div>
                      <v-img
                        :contain=" true "
                        :src=" day.image.image_lg "
                      ></v-img>
                    </div>
                  </v-card>
                </template>
                <!-- END: IMAGE TAB **************************************** -->

                <!-- BEGIN: ANNOUNCEMENT TAB ******************************* -->
                <template v-if=" day.type == 'announcement' ">
                  <v-card flat>
                    <h1>{{ day.announcement }}</h1>
                  </v-card>
                </template>
                <!-- END: ANNOUNCEMENT TAB ********************************* -->

                <!-- BEGIN: SCHEDULE TAB *********************************** -->
                <template v-if=" day.type == 'schedule' ">
                  <v-card flat>
                    <h1 class="main_text">{{ day.schedule.title }}</h1>
                    <h3 class="main_text">{{ day.date }}</h3>
                    <template v-if=" day.schedule.events.length > 0 ">
                      <table class="fixed_header table table-striped">
                        <thead>
                          <th>Time</th>
                          <th>Event</th>
                          <th>Location</th>
                        </thead>
                        <tbody class="table_body">
                          <tr
                            v-for=" event in day.schedule.events "
                            :key=" event.vue_id "
                          >
                            <td>{{ event.time_range }}</td>
                            <td>{{ event.title }}</td>
                            <td>{{ event.location }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </template>
                    <template v-if=" day.breakout.session_blocks.length > 0 ">
                      <h3 class="main_text">{{ day.breakout.title }}</h3>
                    </template>
                  </v-card>
                </template>
                <!-- END: SCHEDULE TAB ************************************* -->

              </v-tab-item>

            </v-tabs>

            <a href="touchscreen#/">
              <v-btn
                color="primary"
                dark
                absolute
                bottom
                left
                fab
              >
                <v-icon>home</v-icon>
              </v-btn>
            </a>

            <v-bottom-sheet v-model="sheet">
              <v-btn
                slot="activator"
                color="purple"
                dark
                absolute
                bottom
                right
                fab
              >
                <v-icon>list</v-icon>
              </v-btn>
              <v-list>
                <div class="drawer">
                  <nav-drawer></nav-drawer>
                </div>
              </v-list>
            </v-bottom-sheet>

          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
    ],
    /** -------------------------------------------------------------------- **/
    data ()
    {
      return(
        {
          scheduleFrequencyMs: 5000,
          active: null,
          agenda: [],
          sheet: false,
          tiles: [
            { img: 'keep.png', title: 'Keep' },
            { img: 'inbox.png', title: 'Inbox' },
            { img: 'hangouts.png', title: 'Hangouts' },
            { img: 'messenger.png', title: 'Messenger' },
            { img: 'google.png', title: 'Google+' }
          ]
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    computed:
    {
    },
    /** -------------------------------------------------------------------- **/
    onIdle: function ()
    {
      let vueInstance = this;
      vueInstance.getAgenda();
      console.log( 'sleeping' );
    },
    /** -------------------------------------------------------------------- **/
    onActive: function ()
    {
      console.log( 'awake' );
    },
    /** -------------------------------------------------------------------- **/
    methods:
    {
      /** ------------------------------------------------------------------ **/
      scheduleGetAgenda: function ()
      {
        let vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.getAgenda();
          },
          vueInstance.scheduleFrequencyMs
        );
      },
      /** ------------------------------------------------------------------ **/
      getAgenda: function ()
      {
        let vueInstance = this;
        axios
        .get( '/api/touch-screen/get-agenda' )
        .then(
          response => {
            console.log( response.data );
            vueInstance.agenda = response.data;
            console.log( "AGENDA:", vueInstance.agenda );
            vueInstance.scheduleGetAgenda();
          }
        );
      }
    },
    /** -------------------------------------------------------------------- **/
    beforeMount: function ()
    {
      this.getAgenda();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .drawer
  {
    background-color:var( --ot-white );
    padding-top: -10vh;
  }

  .main-content
  {
    top:8vh;
    position:relative;
  }

  .fixed_header
  {
    width: 80vw;
    table-layout: fixed;
    border-collapse: collapse;
  }

  table tbody,
  .main_text
  {
    padding-left: 20px;
  }

  .fixed_header tbody
  {
    display:block;
    width: 100%;
    overflow: auto;
    height: 40vh;
  }

  .fixed_header thead tr
  {
    display: block;
  }

  .fixed_header thead
  {
    background: black;
    color:#fff;
  }

  .fixed_header th, .fixed_header td
  {
    padding: 5px;
    text-align: left;
    width: 85vw;
  }

</style>
