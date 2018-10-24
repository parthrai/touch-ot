<template>
  <div class="final-countdown-container">

    <h1 v-if=" title.length > 0 ">{{ title }}</h1>

    <span class="final-countdown-days">
      <span
        v-for=" ( value, index ) in tempus.days "
        :key=" 'days' + index "
      >
        <seven-segment-display
          :debug=" debug "
          :digit=" value "
          :width=" 700 "
          :height=" 1200 "
        ></seven-segment-display>
      </span>
    </span>

    <seven-segment-display-dots
      :debug=" debug "
      :on-or-off=" dots "
      :width=" 200 "
      :height=" 1200 "
    ></seven-segment-display-dots>

    <span class="final-countdown-time">

      <span
        v-for=" ( value, index ) in tempus.hours "
        :key=" 'hours' + index "
      >
        <seven-segment-display
          :debug=" debug "
          :digit=" value "
          :width=" 700 "
          :height=" 1200 "
        ></seven-segment-display>
      </span>

      <seven-segment-display-dots
        :debug=" debug "
        :on-or-off=" dots "
        :width=" 200 "
        :height=" 1200 "
      ></seven-segment-display-dots>

      <span
        v-for=" ( value, index ) in tempus.minutes "
        :key=" 'minutes' + index "
      >
        <seven-segment-display
          :debug=" debug "
          :digit=" value "
          :width=" 700 "
          :height=" 1200 "
        ></seven-segment-display>
      </span>

      <seven-segment-display-dots
        :debug=" debug "
        :on-or-off=" dots "
        :width=" 200 "
        :height=" 1200 "
      ></seven-segment-display-dots>

      <span
        v-for=" ( value, index ) in tempus.seconds "
        :key=" 'seconds' + index "
      >
        <seven-segment-display
          :debug=" debug "
          :digit=" value "
          :width=" 700 "
          :height=" 1200 "
        ></seven-segment-display>
      </span>

    </span>

  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'debug',
      'eventInstanceName',
      'title',
      'targetDate',
      'recalcFrequencyMs',
      'dotsFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          tempus: {
            days: [ 0, 0 ],
            hours: [ 0, 0 ],
            minutes: [ 0, 0 ],
            seconds: [ 0, 0 ]
          },
          dots: true
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      doRecalc: function ()
      {
        
        const vueInstance        = this;
        const MS_PER_DAY         = 1000 * 60 * 60 * 24;
        const MS_PER_HOUR        = 1000 * 60 * 60;
        const MS_PER_MINUTE      = 1000 * 60;
        const MS_PER_SECOND      = 1000;
        const MS_PER_MILLISECOND = 1;
        const current_date       = new Date( Date.now() );
        const target_date        = new Date( vueInstance.targetDate );
        const current_date_value = current_date.valueOf();
        const target_date_value  = target_date.valueOf();

        let tempus_fugit = {
          days: [],
          hours: [],
          minutes: [],
          seconds: []
        };

        if( vueInstance.debug )
        {
          console.log( "current_date_value:", current_date_value );
          console.log( "target_date_value:", target_date_value );
        }

        if( target_date_value > current_date_value )
        {

          let diff_days          = Math.floor( ( target_date_value - current_date_value ) / MS_PER_DAY );
          let diff_days_value    = diff_days * MS_PER_DAY;
          let diff_hours         = Math.floor( ( target_date_value - current_date_value - diff_days_value ) / MS_PER_HOUR );
          let diff_hours_value   = diff_hours * MS_PER_HOUR;
          let diff_minutes       = Math.floor( ( target_date_value - current_date_value - diff_days_value - diff_hours_value ) / MS_PER_MINUTE );
          let diff_minutes_value = diff_minutes * MS_PER_MINUTE;
          let diff_seconds       = Math.floor( ( target_date_value - current_date_value - diff_days_value - diff_hours_value - diff_minutes_value ) / MS_PER_SECOND );
          let diff_seconds_value = diff_seconds * MS_PER_SECOND;

          if( vueInstance.debug )
          {
            console.log( "diff_days:", diff_days );
            console.log( "diff_hours:", diff_hours );
            console.log( "diff_minutes:", diff_minutes );
            console.log( "diff_seconds:", diff_seconds );
          }

          tempus_fugit.days    = diff_days.toString().replace( /^(.)$/, ["0",diff_days].join('') ).split('');
          tempus_fugit.hours   = diff_hours.toString().replace( /^(.)$/, ["0",diff_hours].join('') ).split('');
          tempus_fugit.minutes = diff_minutes.toString().replace( /^(.)$/, ["0",diff_minutes].join('') ).split('');
          tempus_fugit.seconds = diff_seconds.toString().replace( /^(.)$/, ["0",diff_seconds].join('') ).split('');

          if( vueInstance.debug )
          {
            console.log( "tempus_fugit:", tempus_fugit );
            console.log( "tempus_fugit.days:", tempus_fugit.days );
            console.log( "tempus_fugit.hours:", tempus_fugit.hours );
            console.log( "tempus_fugit.minutes:", tempus_fugit.minutes );
            console.log( "tempus_fugit.seconds:", tempus_fugit.seconds );
          }

          vueInstance.tempus.days.splice( 0, 2, tempus_fugit.days[0], tempus_fugit.days[1] );
          vueInstance.tempus.hours.splice( 0, 2, tempus_fugit.hours[0], tempus_fugit.hours[1] );
          vueInstance.tempus.minutes.splice( 0, 2, tempus_fugit.minutes[0], tempus_fugit.minutes[1] );
          vueInstance.tempus.seconds.splice( 0, 2, tempus_fugit.seconds[0], tempus_fugit.seconds[1] );

        }
        else
        {
          console.log( "Temporal Displacement Error!" );
        }

        vueInstance.scheduleRecalc();

      },
      /** ------------------------------------------------------------------ **/
      updateDots: function ()
      {
        let vueInstance = this;
        if( vueInstance.dots == true )
        {
          vueInstance.dots = false;
        }
        else
        {
          vueInstance.dots = true;
        }
        vueInstance.scheduleDots();
      },
      /** ------------------------------------------------------------------ **/
      scheduleRecalc: function ()
      {
        let vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.doRecalc();
          },
          vueInstance.recalcFrequencyMs
        );
      },
      /** ------------------------------------------------------------------ **/
      scheduleDots: function ()
      {
        let vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.updateDots();
          },
          vueInstance.dotsFrequencyMs
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
      vueInstance.doRecalc();
      vueInstance.scheduleDots();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .final-countdown-container
  {
    margin: 22vh auto 10vh auto;
    white-space: nowrap;
    text-align:center;
    h1
    {
      font-size:4vh;
      font-weight:bold;
      white-space:normal;
      color:$ot_white;
      text-shadow:0px 0px 3px rgba( 0, 0, 0, 1 );
      margin:2vh 5vw 2vh 5vw;
    }
    .final-countdown-days
    {
      display:inline-block;
      margin:0vh 0vw 0vh 0vw;
    }
    .final-countdown-time
    {
      display:inline-block;
    }
  }

</style>
