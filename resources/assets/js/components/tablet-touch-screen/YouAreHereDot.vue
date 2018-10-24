<template>
  <div :id=" containerId ">
    <span class="message">{{ label }}</span>
    <svg height="60" width="60">
      <g>
        <circle cx="28" cy="28" r="28" fill="none" stroke="#D92A32" stroke-width="3" stroke-opacity="1.0">
          <animate attributeType="xml" attributeNAMe="r" from="0" to="28" dur="2s" repeatCount="indefinite" />
          <animate attributeType="xml" attributeNAMe="stroke-opacity" from="1.0" to="0" dur="2s" repeatCount="indefinite" />
        </circle>
        <circle cx="28" cy="28" r="28" fill="none" stroke="#D92A32" stroke-width="3" stroke-opacity="1.0">
          <animate attributeType="xml" attributeNAMe="r" from="0" to="28" dur="2s" begin="0.5s" repeatCount="indefinite" />
          <animate attributeType="xml" attributeNAMe="stroke-opacity" from="1.0" to="0" dur="2s" begin="0.5s" repeatCount="indefinite" />
        </circle>
        <circle cx="28" cy="28" r="28" fill="none" stroke="#D92A32" stroke-width="3" stroke-opacity="1.0">
          <animate attributeType="xml" attributeNAMe="r" from="0" to="28" dur="2s" begin="1s" repeatCount="indefinite" />
          <animate attributeType="xml" attributeNAMe="stroke-opacity" from="1.0" to="0" dur="2s" begin="1s" repeatCount="indefinite" />
        </circle>
        <circle cx="28" cy="28" r="5" fill="#D92A32" stroke="#D92A32"></circle>
      </g>
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
      'label'
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

</style>
