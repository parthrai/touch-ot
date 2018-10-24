<template>
  <div
    :id=" containerId "
    class="expo-map-display"
  >
    <img
      :id=" mapImageId "
      class="expo-map-image"
      :src=" mapImage "
    >
    <div
      :id=" markerId "
      class="expo-map-marker"
    >
      <svg
        version="1.1"
        id="Layer_2"
        xmlns="http://www.w3.org/2000/svg"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        x="0px"
        y="0px"
        viewBox="0 0 32.8 55"
        style="enable-background:new 0 0 32.8 55;"
        xml:space="preserve"
      >
        <circle class="st2" cx="16.4" cy="16.6" r="13"></circle>
        <circle class="st0" cx="16.4" cy="16.6" r="9.3">
          <animate attributeType="xml" attributeNAMe="r" from="0" to="9.3" dur="0.5s" repeatCount="indefinite"></animate>
          <animate attributeType="xml" attributeNAMe="fill-opacity" from="1.0" to="0" dur="0.5s" repeatCount="indefinite"></animate>
        </circle>
      </svg>
    </div>
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
      'mapImageId',
      'mapImage',
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

  .st0
  {
    fill:#D92A32;
  }

  .st2
  {
    fill:none;
    stroke:#D92A32;
    stroke-width:2;
    stroke-linecap:round;
    stroke-linejoin:round;
    stroke-miterlimit:10;
  }

  .expo-map-display
  {
    position:relative;
    .expo-map-image
    {
      width:100%;
      height:auto;
    }
    .expo-map-marker
    {
      position:absolute;
      top:-100px;
      left:0px;
      width:55px;
      height:55px;
    }
  }

</style>
