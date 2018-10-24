<template>

  <transition
    name="social-card"
    appear
  >

    <section class="social-card">

      <strong v-if=" debug == true ">POST</strong>

      <article :class=" computeSocialCardBodyClass( card ) ">

        <div class="social-card-user">
          <span
            v-if=" card.first_name "
            class="social-card-user-name"
          >
            {{ card.first_name }}
          </span>
          <span
            v-if=" card.last_name "
            class="social-card-user-name"
          >
            {{ card.last_name }}
          </span>
          <span
            v-if=" card.title "
            class="social-card-user-title"
          >
            - {{ card.title }}
          </span>
        </div>

        <div
          v-if=" card.company "
          class="social-card-company"
        >
          {{ card.company }}
        </div>

        <div>
          <div v-if=" card.image ">
            <div class="social-card-text">{{ card.post_text }}</div>
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
              v-if=" card.profile_photo "
              class="social-card-avatar"
            >
              <img :src=" card.profile_photo ">
            </span>
            <div class="social-card-text">
              {{ card.post_text }}
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
        var classNames  = new String( 'social-card-body social-card-body-appworks-post' );
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

  /** BEGIN: SocialCardAppworksPost.vue Styles ----------------------------- **/

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

  .social-card-body-appworks-post
  {
    border-color:$ot_purple;
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

    .social-card-user
    {
      margin:0.5vh 0.5vw 0.5vh 0.5vw;
    }

    .social-card-user-name
    {
      color:$ot_black;
      font-weight:bold;
    }

    .social-card-user-title
    {
      font-style:italic;
    }

    .social-card-company
    {
      color:$ot_blue;
      font-weight:bold;
      margin:0.5vh 0.5vw 1vh 0.5vw;
    }

    .social-card-text
    {
      margin:0.5vh 0.5vw 1vh 0.5vw;
    }

  }

  /** END: SocialCardAppworksPost.vue Styles ------------------------------- **/

</style>
