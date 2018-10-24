<template>
    <div class="row">
        <div class="col-lg-12" id="content">
            <v-container grid-list-md text-xs-center>
                <v-layout>
                    <v-flex xs12>
                        <v-card>
                            <v-tabs
                                    v-model="active"
                                    slider-color="black" >

                                <v-tab ripple>
                                    Networking Opportunities

                                </v-tab>
                                <v-tab ripple>
                                    Women in Technology Summit

                                </v-tab>

                                <v-tab ripple>
                                    Closing Night Celebration

                                </v-tab>

                                <v-tab-item

                                >
                                    <v-card flat>
                                        <img src="images/touchscreen/networking-opportunities.png" height="400" width="100%">
                                    </v-card>
                                </v-tab-item>

                                <v-tab-item

                                >
                                    <v-card flat>
                                        <img src="images/touchscreen/women-in-tech.jpg" height="400" width="100%">
                                    </v-card>
                                </v-tab-item>

                                <v-tab-item

                                >
                                    <v-card flat>
                                        <img src="images/touchscreen/closing-night-celebration.jpg" height="400" width="100%">
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
                        </v-card>


                    </v-flex>






                </v-layout>
            </v-container>
        </div>


    </div>

</template>

<style>
    .row{
        width:100%;
        position:fixed;


    }

    #content{
        padding-top:100px;

    }
</style>