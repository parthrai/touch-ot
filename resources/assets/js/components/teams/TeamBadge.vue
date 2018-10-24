<template>
  <span
    class="team-badge"
    :title=" teamName "
  >
    <canvas
      :class=" canvasClass "
      :width=" badgeWidth "
      :height=" badgeHeight "
    ></canvas>
  </span>
</template>

<script>
  export default
  {
    props: [
      'debug',
      'canvasClass',
      'teamName',
      'badgeLabel',
      'badgeWidth',
      'badgeHeight',
      'badgeBackgroundColor',
      'badgeTextColor'
    ],
    data: function ()
    {
      return(
        {
          canvas: null,
          ctx: null,
        }
      );
    },
    watch:
    {
      teamName: function ()
      {
        let vueInstance = this;
        vueInstance.drawBadge();
      },
      badgeLabel: function ()
      {
        let vueInstance = this;
        vueInstance.drawBadge();
      },
      badgeBackgroundColor: function ()
      {
        let vueInstance = this;
        vueInstance.drawBadge();
      },
      badgeTextColor: function ()
      {
        let vueInstance = this;
        vueInstance.drawBadge();
      }
    },
    methods: {
      drawBadge: function ()
      {

        let vueInstance       = this;
        
        let ctx               = vueInstance.ctx;
        let canvas            = vueInstance.canvas;
        let canvasWidth       = canvas.width;
        let canvasHeight      = canvas.height;
        let centerPoint       = canvasWidth / 2;
        let outerCircleRadius = ( ( canvasWidth / 100 ) * 95 ) / 2;
        let innerCircleRadius = ( ( canvasWidth / 100 ) * 80 ) / 2;
        let textSize          = ( canvasWidth / 100 ) * 30;
        
        ctx.fillStyle         = vueInstance.badgeBackgroundColor;
        ctx.strokeStyle       = 'white';
        ctx.lineWidth         = ( canvasWidth / 100 ) * 5;
        ctx.font              = textSize + 'px "aktiv-grotesk", Helvetica, Arial, sans-serif';
        ctx.textAlign         = 'center';
        ctx.textBaseline      = 'middle';
        
        ctx.clearRect( 0, 0, canvasWidth, canvasHeight );

        ctx.beginPath();
        ctx.arc( centerPoint, centerPoint, outerCircleRadius, 0, Math.PI * 2, true );
        ctx.stroke();
        ctx.fill();
        
        ctx.beginPath();
        ctx.arc( centerPoint, centerPoint, innerCircleRadius, 0, Math.PI * 2, true );
        ctx.stroke();
        ctx.fillStyle = vueInstance.badgeTextColor;
        ctx.fillText( vueInstance.badgeLabel, centerPoint, centerPoint );

      }
    },
    created: function ()
    {
      let vueInstance = this;
    },
    mounted: function ()
    {
      let vueInstance    = this;
      vueInstance.canvas = vueInstance.$el.querySelector( 'canvas' );
      vueInstance.ctx    = vueInstance.canvas.getContext( '2d' );
      vueInstance.drawBadge();
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .team-badge
  {
    text-align:center;
    vertical-align:middle;
    display:inline-block;
    margin-left:auto;
    margin-right:auto;
  }

</style>
