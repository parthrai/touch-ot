<template>
    <v-container grid-list-md>
        <v-layout row wrap>

            <v-flex xs10 offset-xs1>
                <v-card>
                    <v-tabs
                            v-model="active"
                            slider-color="black" >

                        <v-tab ripple>
                           Level 100

                        </v-tab>
                        <v-tab ripple>
                            Level 200
                        </v-tab>

                        <v-tab ripple>
                            Level 300

                        </v-tab>

                        <v-tab ripple 	v-model="active_tab">
                            Level 400
                        </v-tab>

                        <v-tab ripple>
                            Level 500
                        </v-tab>

                        <v-tab ripple>
                            Level 600
                        </v-tab>

                        <v-tab ripple>
                            Level 700
                        </v-tab>

                        <v-tab ripple>
                            Level 800
                        </v-tab>

                        <v-tab ripple>
                            InterContinental
                        </v-tab>

                        <v-tab-item @click="cords()">
                            <v-card flat>

                                <img src="images/touchscreen/level100.png" height="600" width="100%" class="img">
                                <img alt="snowballAppear" id="snowballAppear"  src="https://cdn1.iconfinder.com/data/icons/social-messaging-ui-color/254000/67-512.png"  class="marker" height="100" width="100"/>

                            </v-card>
                        </v-tab-item>

                        <v-tab-item @click="cords()">
                            <v-card flat>
                                <img src="images/touchscreen/level200.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>

                        <v-tab-item>
                            <v-card flat>
                                <img src="images/touchscreen/level300.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>

                        <v-tab-item>
                            <v-card flat>
                                <img src="images/touchscreen/level400.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>

                        <v-tab-item>
                            <v-card flat>
                                <img src="images/touchscreen/level500.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>

                        <v-tab-item>
                            <v-card flat>
                                <img src="images/touchscreen/level600.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>

                        <v-tab-item>
                            <v-card flat>
                                <img src="images/touchscreen/level700.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>

                        <v-tab-item>
                            <v-card flat>
                                <img src="images/touchscreen/level800.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>

                        <v-tab-item>
                            <v-card flat>
                                <img src="images/touchscreen/intercontential.png" height="400" width="100%">
                            </v-card>
                        </v-tab-item>
                    </v-tabs>

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




                </v-card>

            </v-flex>



        </v-layout>
    </v-container>

</template>

<script>
    export default {
        data() {


            return {

                sheet: false,
                tiles: [
                    {img: 'keep.png', title: 'Keep'},
                    {img: 'inbox.png', title: 'Inbox'},
                    {img: 'hangouts.png', title: 'Hangouts'},
                    {img: 'messenger.png', title: 'Messenger'},
                    {img: 'google.png', title: 'Google+'}
                ]
            }

         },

        mounted(){
            console.log("before mount");
            console.log(localStorage.getItem("cordX"));
            console.log(localStorage.getItem("cordY"));

            var snowball = document.getElementById("snowballAppear");

            snowball.style.position = 'absolute';
            snowball.style.left = localStorage.getItem("cordX") + 'px';
            snowball.style.top = localStorage.getItem("cordY") + 'px';


        },

        methods:{

            cords(event){
                console.log(window.event.clientX ); // x coordinate
                console.log(window.event.clientY ); // y coordinate

                var x = window.event.pageX;
                var y = window.event.pageY;
                var snowball = document.getElementById("snowballAppear");

                snowball.style.position = 'absolute';
                snowball.style.left = localStorage.getItem("cordX") + 'px';
                snowball.style.top = localStorage.getItem("cordY") + 'px';

                localStorage.setItem("cordX", x);
                localStorage.setItem("cordY", y);



            }

        }


    }
</script>


<style>
    .img{
        z-index:1;
    }

    .marker{
        z-index:100;
        position:absolute;

    }
</style>