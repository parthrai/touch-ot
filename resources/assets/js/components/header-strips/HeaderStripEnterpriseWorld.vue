<template>
  <div class="header-strip">
    <div class="header-strip-elements">
      <img
        class="header-strip-logo"
        src="/images/opentext-logos/OpenText-Logo-2017.png"
      >
      <span class="header-strip-text">&nbsp;|&nbsp;</span>
      <span class="header-strip-text">{{ label }}</span>
    </div>
  </div>
</template>

<script>
  export default
  {
    props: [
      'label'
    ],
    data: function ()
    {
      return(
        {
        }
      );
    },
    methods: {
    },
    created: function ()
    {
      let vueInstance = this;
    },
    mounted: function ()
    {
      let vueInstance = this;
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .header-strip
  {

    position:fixed;

    top:0vh;
    left:0vw;
    
    width:100vw;
    height:10vh;

    margin:0vh auto 0vh auto;

    .header-strip-elements
    {
      
      text-align:center;
      margin:0vh auto 0vh auto;

      img.header-strip-logo
      {
        height:10vh;
        filter:drop-shadow( 0px 0px 10px $ot_white );
      }

      .header-strip-text
      {
        font-size:5vh;
        color:$ot_white;
        text-shadow:0px 0px 5px $ot_black;
        white-space:nowrap;
        vertical-align:middle;
      }

    }

  }

</style>
