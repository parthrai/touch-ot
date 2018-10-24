<template>
  <div :id="containerId">
    <svg
      version="1.1"
      id="Layer_1"
      xmlns="http://www.w3.org/2000/svg"
      xmlns:xlink="http://www.w3.org/1999/xlink"
      x="0px"
      y="0px"
      viewBox="0 0 52 52"
      style="enable-background:new 0 0 52 52;"
      xml:space="preserve"
    >
      <polygon
        class="st1"
        points="29.2,39.1 29.2,32.7 22.8,32.7 22.8,39.1 16.9,39.1 16.9,26.7 12.2,26.7 26,12.9 39.8,26.7 35.1,26.7 35.1,39.1 "
      />
    </svg>
  </div>
</template>

<script>
  export default
  {
    /** -------------------------------------------------------------------- **/
    props: [
      'debug',
      'eventInstanceName',
      'containerId',
      'markerId'
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
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .st1
  {
    fill:none;
    stroke:#fff;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
    stroke-miterlimit:10;
  }

</style>

