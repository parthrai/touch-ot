<template>
  <div class="test-card-container">
    <img
      class="img-responsive test-card-image"
      :src=" testCardImageUrl "
    >
  </div>
</template>

<script>
  export default
  {
    props: [
      'testCardImageUrl',
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

  .test-card-container
  {
    position:relative;
    width:90vw;
    height:80vh;
    margin-left:auto;
    margin-right:auto;

    .test-card-image
    {
      top:40%;
      left:50%;
      width:50%;
      max-height:80vh;
      position:absolute;
      transform:translate( -50%, -50% );
      margin:0px;
      filter:drop-shadow( 0px 0px 10px $ot_blue );
    }

  }
  
</style>
