<template>
  <div class="logo-container">
    <img
      class="img-responsive logo"
      :src=" logoUrl "
    >
  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'debug',
      'eventInstanceName',
      'logoUrl',
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

  .logo-container
  {
    position:relative;
    width:90vw;
    height:80vh;
    margin-left:auto;
    margin-right:auto;
    .logo
    {
      position:absolute;
      transform:translate(-50%,-50%);
      top:40%;
      left:50%;
      width:100%;
      max-height:80vh;
      margin:0px;
    }
  }
  
</style>
