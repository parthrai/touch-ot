<template>
   <div class="row" id="rr">
       <div class="col-md-3" id="dd">

         <div id="cc">
           <v-tabs
                   v-model="active"

                   slider-color="black"
           >
               <v-tab ripple>
                   OpenText

               </v-tab>
               <v-tab ripple>
                   Partners

               </v-tab>

               <v-tab-item
                       v-for="n in 3"
                       :key="n"
               >
                   <v-card flat>
                       <v-card-text>{{ text }}</v-card-text>
                   </v-card>
               </v-tab-item>

           </v-tabs>
           </div>

       </div>
       <div class="col-md-9" id="ss">
           <img src="images/touchscreen/expomap.png" height="400" width="100%">
           <a href="touchscreen#/">
               <v-btn
                       color="primary"
                       dark

                       absolute
                       bottom
                       left
                       fab
               >
                   <v-icon>home</v-icon>
               </v-btn>
           </a>

           <v-bottom-sheet v-model="sheet">
               <v-btn
                       slot="activator"
                       color="purple"
                       dark
                       absolute
                       bottom
                       right
                       fab
               >
                   <v-icon>list</v-icon>
               </v-btn>

               <v-list>

                   <v-subheader>Open in</v-subheader>
                   <home></home>
               </v-list>


           </v-bottom-sheet>



       </div>



   </div>
</template>

<style>
 h1{
     color:red;
 }
#rr{

    margin-left:10px;
    width:100%;

}
    #dd{
        background-color: #38c172;
        opacity:0.5;

    }

    #cc{
        opacity: 1;
    }

</style>

<script>
    export default {
        data() {
            return {
                active: null,
                text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
            }
        },
        methods: {
            next() {
                const active = parseInt(this.active)
                this.active = (active < 2 ? active + 1 : 0)
            }
        }
    }
</script>