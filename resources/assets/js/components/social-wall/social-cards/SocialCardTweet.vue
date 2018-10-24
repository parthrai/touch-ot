<template>

  <transition
    name="social-card"
    appear
  >

    <section class="social-card">

      <strong v-if=" debug == true ">TWEET</strong>

      <article :class=" computeSocialCardBodyClass( card ) ">

        <div
          v-if=" card.user_screen_name "
          class="social-card-user-name"
        >
          @{{ card.user_screen_name }}
        </div>
        <div>
          <div v-if=" card.image ">
            <div class="social-card-text">{{ card.tweet_text }}</div>
            <div>

              <transition
                appear
                appear-class="social-card-image-appear"
                appear-to-class="social-card-image"
                appear-active-class="social-card-image"
              >
                <img
                  class="img-responsive social-card-image"
                  :src=" card.image "
                >
              </transition>

            </div>
          </div>
          <div v-else>
            <span
              v-if=" card.user_image "
              class="social-card-avatar"
            >
              <img :src=" card.user_image ">
            </span>
            <div class="social-card-text">
              {{ card.tweet_text }}
            </div>
          </div>
        </div>

      </article>

    </section>

  </transition>

</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'debug',
      'card'
    ],
    /** -------------------------------------------------------------------- **/
    data: function ()
    {
      return(
        {
        }
      );
    },
    /** -------------------------------------------------------------------- **/
    methods: {
      /** ------------------------------------------------------------------ **/
      computeSocialCardBodyClass: function ( card )
      {

        const vueInstance = this;
        var classNames  = new String( 'social-card-body' );
        classNames      = classNames.concat( ' ', 'social-card-body-twitter' );

        if( ( card.image !== null ) && ( card.image.length > 0 ) )
        {
          classNames = classNames.concat( ' ', 'social-card-body-twitter-with-image' );
        }

        if( card.featured == true )
        {
          classNames = classNames.concat( ' ', 'social-card-body-featured' );
        }

        return( classNames.toString() );

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
    }
    /** -------------------------------------------------------------------- **/
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  /** BEGIN: SocialCardTweet.vue Styles ------------------------------------ **/

  .social-card
  {

    display:inline-block;
    margin-top:0vh;
    margin-bottom:1vh;

    &-enter-active,
    &-leave-active
      {
      transition-property:opacity, transform;
      transition-duration:2.0s;
      transition-timing-function:ease;
    }

    &-enter-active
    {
      transition-delay:100ms;
    }

    &-enter,
    &-leave-to
    {
      opacity:0;
      transform:scale( 0.5, 0.5 );
    }

    &-leave,
    &-enter-to
    {
      opacity:1;
      transform:scale( 1.0, 1.0 );
    }

    &-move
    {
      transition-property:all;
      transition-duration:2.0s;
      transition-timing-function:ease;
    }

  }

  .social-card-body
  {
    font-size:12pt;
    line-height:15pt;
    border-style:solid;
    border-width:6px 0px 0px 0px;
    border-color:$ot_blue;
    background-color:rgba(255,255,255,0.8);
    box-shadow: 0px 0px 10px rgba(64,64,255,0.4);
  }

  .social-card-body-twitter
  {
    border-color:$ot_teal;
    background-image:url('/images/social-media-logos/Twitter_Logo_Blue_Trans.png');
    background-position: bottom 0vw right 0vw;
    background-size:4vw;
    background-repeat:no-repeat;
  }

  .social-card-body-twitter-with-image
  {
    background-position: top 0vw right 0vw;
  }

  .social-card-body-featured
  {
    border-width:12px 0px 0px 0px;
    border-color:$ot_red;
  }

  .social-card-body
  {

    overflow:hidden;

    .social-card-avatar
    {
      float:right;
      margin:1vh 0.5vw 1vh 0.5vw;
      img
      {
        width:2vw;
      }
    }

    .social-card-image
    {
      margin:0px;
      opacity:1;
      transition-property:opacity;
      transition-duration:1.0s;
      transition-timing-function:ease-in-out;
      .social-card-image-appear
      {
        opacity:0;
      }
    }

    .social-card-user-name
    {
      color:$ot_black;
      font-weight:bold;
      margin:0.5vh 0.5vw 1vh 0.5vw;
    }

    .social-card-text
    {
      margin:0.5vh 0.5vw 1vh 0.5vw;
    }

  }

  /** END: SocialCardTweet.vue Styles -------------------------------------- **/

</style>
