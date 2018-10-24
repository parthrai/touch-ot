<!--
  REFERENCE:
    https://en.wikipedia.org/wiki/Seven-segment_display
-->

<template>
  <span class="seven-segment-display">
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
      'digit',
      'width',
      'height'
    ],
    data: function ()
    {
      return(
        {
          canvas: null,
          ctx: null,
          digit_current: 0
        }
      );
    },
    watch:
    {
      digit: function ()
      {

        let vueInstance = this;

        if( vueInstance.digit !== vueInstance.digit_current )
        {
          vueInstance.digit_current = vueInstance.digit;
          vueInstance.drawDigit();
        }

      }
    },
    methods: {
      drawDigit: function ()
      {

        let vueInstance    = this;
        let digit          = vueInstance.digit;
        let ctx            = vueInstance.ctx;
        let canvas         = vueInstance.canvas;
        let canvasWidth    = canvas.width;
        let canvasHeight   = canvas.height;
        let blockSizeX     = canvasWidth / 7;
        let blockSizeY     = canvasHeight / 12;
        let blockInset     = canvasWidth / 100;
        let blockInsetMore = canvasWidth / 50;

        if( vueInstance.debug )
        {
          console.log( "canvasWidth / canvasHeight:", canvasWidth, canvasHeight );
          console.log( "blockSizeX:", blockSizeX );
        }
        
        /** ---------------------------------------------------------------- **/

        let SegmentHorizontal = function ( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY )
        {
          ctx.lineJoin    = 'round';
          ctx.lineWidth   = 1;
          ctx.fillStyle   = color;
          ctx.strokeStyle = color;
          ctx.beginPath();
          ctx.moveTo( ( blockSizeX * ( 0 + offsetX ) ) + blockInsetMore, ( blockSizeY * ( 1 + offsetY ) ) );
          ctx.lineTo( ( blockSizeX * ( 1 + offsetX ) ) + blockInset, ( blockSizeY * ( 0 + offsetY ) ) + blockInset );
          ctx.lineTo( ( blockSizeX * ( 4 + offsetX ) ) - blockInset, ( blockSizeY * ( 0 + offsetY ) ) + blockInset );
          ctx.lineTo( ( blockSizeX * ( 5 + offsetX ) ) - blockInsetMore, ( blockSizeY * ( 1 + offsetY ) ) );
          ctx.lineTo( ( blockSizeX * ( 4 + offsetX ) ) - blockInset, ( blockSizeY * ( 2 + offsetY ) ) - blockInset );
          ctx.lineTo( ( blockSizeX * ( 1 + offsetX ) ) + blockInset, ( blockSizeY * ( 2 + offsetY ) ) - blockInset );
          ctx.closePath();
          ctx.stroke();
          ctx.fill();
        };

        let SegmentVertical = function ( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY )
        {
          ctx.lineJoin    = 'round';
          ctx.lineWidth   = 1;
          ctx.fillStyle   = color;
          ctx.strokeStyle = color;
          ctx.beginPath();
          ctx.moveTo( ( blockSizeX * ( 0 + offsetX ) ) + blockInset, ( blockSizeY * ( 1 + offsetY ) ) + blockInset );
          ctx.lineTo( ( blockSizeX * ( 1 + offsetX ) ), ( blockSizeY * ( 0 + offsetY ) ) + blockInsetMore );
          ctx.lineTo( ( blockSizeX * ( 2 + offsetX ) ) - blockInset, ( blockSizeY * ( 1 + offsetY ) ) + blockInset );
          ctx.lineTo( ( blockSizeX * ( 2 + offsetX ) ) - blockInset, ( blockSizeY * ( 4 + offsetY ) ) - blockInset );
          ctx.lineTo( ( blockSizeX * ( 1 + offsetX ) ), ( blockSizeY * ( 5 + offsetY ) ) - blockInsetMore );
          ctx.lineTo( ( blockSizeX * ( 0 + offsetX ) ) + blockInset, ( blockSizeY * ( 4 + offsetY ) ) - blockInset );
          ctx.closePath();
          ctx.stroke();
          ctx.fill();
        };

        /** ---------------------------------------------------------------- **/

        let SegmentA = function ( ctx, blockSizeX, blockSizeY, color )
        {
          let offsetX = 1;
          let offsetY = 0;
          SegmentHorizontal( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY );
        };

        let SegmentB = function ( ctx, blockSizeX, blockSizeY, color )
        {
          let offsetX = 5;
          let offsetY = 1;
          SegmentVertical( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY );
        };

        let SegmentC = function ( ctx, blockSizeX, blockSizeY, color )
        {
          let offsetX = 5;
          let offsetY = 6;
          SegmentVertical( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY );
        };

        let SegmentD = function ( ctx, blockSizeX, blockSizeY, color )
        {
          let offsetX = 1;
          let offsetY = 10;
          SegmentHorizontal( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY );
        };

        let SegmentE = function ( ctx, blockSizeX, blockSizeY, color )
        {
          let offsetX = 0;
          let offsetY = 6;
          SegmentVertical( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY );
        };

        let SegmentF = function ( ctx, blockSizeX, blockSizeY, color )
        {
          let offsetX = 0;
          let offsetY = 1;
          SegmentVertical( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY );
        };

        let SegmentG = function ( ctx, blockSizeX, blockSizeY, color )
        {
          let offsetX = 1;
          let offsetY = 5;
          SegmentHorizontal( ctx, blockSizeX, blockSizeY, color, offsetX, offsetY );
        };

        /** ---------------------------------------------------------------- **/

        let empty_digit = [ SegmentA, SegmentB, SegmentC, SegmentD, SegmentE, SegmentF, SegmentG ];

        let digits = {
          null: [ null, null, null, null, null, null, null ],
          0: [ SegmentA, SegmentB, SegmentC, SegmentD, SegmentE, SegmentF, null ],
          1: [ null, SegmentB, SegmentC, null, null, null, null ],
          2: [ SegmentA, SegmentB, null, SegmentD, SegmentE, null, SegmentG ],
          3: [ SegmentA, SegmentB, SegmentC, SegmentD, null, null, SegmentG ],
          4: [ null, SegmentB, SegmentC, null, null, SegmentF, SegmentG ],
          5: [ SegmentA, null, SegmentC, SegmentD, null, SegmentF, SegmentG ],
          6: [ SegmentA, null, SegmentC, SegmentD, SegmentE, SegmentF, SegmentG ],
          7: [ SegmentA, SegmentB, SegmentC, null, null, null, null ],
          8: [ SegmentA, SegmentB, SegmentC, SegmentD, SegmentE, SegmentF, SegmentG ],
          9: [ SegmentA, SegmentB, SegmentC, SegmentD, null, SegmentF, SegmentG ]
        }

        /** ---------------------------------------------------------------- **/

        ctx.clearRect( 0, 0, canvasWidth, canvasHeight );

        /** ---------------------------------------------------------------- **/

        for( var i = 0 ; i < empty_digit.length ; i++ )
        {
          let color = 'rgba(255,255,255,1.0)'; // $ot_white
          if( empty_digit[i] !== null )
          {
            empty_digit[i]( ctx, blockSizeX, blockSizeY, color );
          }
        }

        /** ---------------------------------------------------------------- **/

        for( var i = 0 ; i < digits[digit].length ; i++ )
        {
          let color = 'rgba(46,61,152,1.0)'; // $ot_blue
          if( digits[digit][i] !== null )
          {
            digits[digit][i]( ctx, blockSizeX, blockSizeY, color );
          }
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
      let vueInstance           = this;
      vueInstance.digit_current = vueInstance.digit;
      vueInstance.canvas        = vueInstance.$el.querySelector( 'canvas' );
      vueInstance.ctx           = vueInstance.canvas.getContext( '2d' );
      vueInstance.drawDigit();
    }
  }
</script>

<style lang="scss" scoped>

  @import '~@/_opentext-branding.scss';

  .seven-segment-display
  {
    margin:1vh 0.1vw 1vh 0.1vw;
    canvas
    {
      display:inline-block;
      width:7vw; /* This is dependent on being 700px wide */
      filter:drop-shadow( 0px 0px 3px rgba( 0, 0, 0, 0.15 ) );
    }
  }

</style>
