<template>
  <div class="rorschach-container">
    <div
      v-for=" ( image, index ) in imageList "
      :key=" image "
    >
      <transition name="rorschach">
        <img
          v-if=" image == currentImage "
          class="rorschach"
          :src=" currentImage "
          :style=" imageRotations[index] "
        >
      </transition>
    </div>
  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'debug',
      'transitionFrequencyMs'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
          imageList: [],
          imageRotations: [],
          currentImage: null,
          currentNum: 0,
          maximumNum: 4
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      doTransition: function ()
      {

        let vueInstance = this;
        let currentNum  = vueInstance.currentNum;
        var nextNum     = currentNum + 1;
        if( nextNum > vueInstance.maximumNum )
        {
          nextNum = 0;
        }
        vueInstance.currentImage = vueInstance.imageList[nextNum];
        vueInstance.currentNum   = nextNum;
        vueInstance.scheduleTransitionCycle();
      },
      /** ------------------------------------------------------------------ **/
      scheduleTransitionCycle: function ()
      {
        let vueInstance = this;
        setTimeout(
          function ()
          {
            vueInstance.doTransition();
          },
          vueInstance.transitionFrequencyMs
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
    beforeMount: function ()
    {
      let vueInstance = this;

      vueInstance.imageList.push( "/images/wallpapers/rorschach/rorschach-ot-blue.jpg" );
      vueInstance.imageList.push( "/images/wallpapers/rorschach/rorschach-ot-grey.jpg" );
      vueInstance.imageList.push( "/images/wallpapers/rorschach/rorschach-ot-purple.jpg" );
      vueInstance.imageList.push( "/images/wallpapers/rorschach/rorschach-ot-red.jpg" );
      vueInstance.imageList.push( "/images/wallpapers/rorschach/rorschach-ot-teal.jpg" );

      vueInstance.currentImage = vueInstance.imageList[0];

      for( var i = 0 ; i < vueInstance.imageList.length ; i++ )
      {
        if( i % 2 == 0 )
        {
          vueInstance.imageRotations.push( {} );
        }
        else
        {
          vueInstance.imageRotations.push(
            {
              transform: 'rotate( 180deg )'
            }
          );
        }
      }

    },
    /** -------------------------------------------------------------------- **/
    mounted: function ()
    {
      let vueInstance = this;
      vueInstance.scheduleTransitionCycle();
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss">

  @import '~@/_opentext-branding.scss';

  .rorschach-container
  {
    position:fixed;
    top:0vh;
    left:0vw;
    width:100vw;
    height:100vh;
    z-index:-10;
  }

  .rorschach
  {

    position:fixed;
    top:0vh;
    left:0vw;
    width:100vw;
    height:100vh;

    &-enter-active,
    &-leave-active
      {
      transition-property:opacity;
      transition-duration:5.0s;
      transition-timing-function:ease;
    }

    &-enter,
    &-leave-to
    {
      opacity:0;
    }
    
    &-leave,
    &-enter-to
    {
      opacity:1;
    }

  }

</style>
