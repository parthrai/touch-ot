<template>
    <div>
        <div class="tile">
            <div class="col-lg-12">
                <img :src="'images/touchscreen/icon/'+ img" height="100" width="100">
            </div>
            <div class="col-lg-12">
                <h4>{{caption}}</h4>
            </div>


        </div>



    </div>
</template>



<script>
    export default{
        props:['img','caption']
    }

</script>

<style>
    #sec1{
        background-color: red;
    }

    #sec2{
        background-color:green;
    }
 .tile{

     border-radius:10px ;
     background-color: rgba(149, 143, 255, 0.15);
     opacity:1;


 }

</style>