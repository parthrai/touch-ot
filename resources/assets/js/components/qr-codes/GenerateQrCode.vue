<template>
  <div class="ot-qr-code">
    <qrcode
      :value=" qrCodeText "
      :options=" { size: 500 } "
    ></qrcode>
  </div>
</template>

<script>
  export default
  {
    props: [
      'qrCodeText'
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

  .ot-qr-code
  {
    display:inline-block;
    margin:5vh auto 0vh auto;
  }

  .ot-qr-code canvas
  {
    border-style:solid;
    border-color:#FFFFFF;
    border-width:1vw;
  }

</style>
