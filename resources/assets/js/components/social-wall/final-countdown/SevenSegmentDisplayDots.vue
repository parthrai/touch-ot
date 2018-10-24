<template>
  <span class="seven-segment-display-dots">
    <canvas
      :width=" width "
      :height=" height "
    ></canvas>
  </span>
</template>

<script>
  export default
  {
    props: [
      'debug',
      'onOrOff',
      'width',
      'height'
    ],
    data: function ()
    {
      return(
        {
          canvas: null,
          ctx: null
        }
      );
    },
    watch:
    {
      onOrOff: function ()
      {
        let vueInstance = this;
        vueInstance.drawDots();
      }
    },
    methods: {
      drawDots: function ()
      {

        let vueInstance  = this;

        let onOrOff      = vueInstance.onOrOff;
        let canvas       = vueInstance.canvas;
        let ctx          = vueInstance.ctx;
        let canvasWidth  = vueInstance.canvas.width;
        let canvasHeight = vueInstance.canvas.height;

        /** ---------------------------------------------------------------- **/

        let renderDots = function ( ctx, canvasWidth, canvasHeight, color )
        {

          ctx.fillStyle   = color;
          ctx.strokeStyle = color;
          ctx.lineWidth   = 1;

          let centerPointX  = canvasWidth / 2;
          let centerPointY  = canvasHeight / 2;
          let circleRadius = ( ( canvasWidth / 100 ) * 80 ) / 2;

          if( vueInstance.debug )
          {
            console.log( "RENDERDOTS:", centerPointX, centerPointY, circleRadius );
          }
          
          ctx.beginPath();
          ctx.arc( centerPointX, centerPointY - ( canvasHeight / 5 ), circleRadius, 0, Math.PI * 2, true );
          ctx.stroke();
          ctx.fill();

          ctx.beginPath();
          ctx.arc( centerPointX, centerPointY + ( canvasHeight / 5 ), circleRadius, 0, Math.PI * 2, true );
          ctx.stroke();
          ctx.fill();

        }

        /** ---------------------------------------------------------------- **/

        ctx.clearRect( 0, 0, canvasWidth, canvasHeight );

        /** ---------------------------------------------------------------- **/

        if( onOrOff === true )
        {
          let color = 'rgba(46,61,152,1.0)'; // $ot_blue
          renderDots( ctx, canvasWidth, canvasHeight, color );
        }
        else
        {
          let color = 'rgba(255,255,255,1.0)'; // $ot_white
          renderDots( ctx, canvasWidth, canvasHeight, color );
        }

        /** ---------------------------------------------------------------- **/

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
      vueInstance.drawDots();
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .seven-segment-display-dots
  {
    margin:1vh 0.1vw 1vh 0.1vw;
    canvas
    {
      display:inline-block;
      width:2vw; /* This is dependent on being 200px wide */
      filter:drop-shadow( 0px 0px 3px rgba( 0, 0, 0, 0.15 ) );
    }
  }

</style>
