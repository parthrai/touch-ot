<template>
    <div class="row">
    <v-container grid-list-md text-xs-center color="#F2F9FF">
        <v-card>
            <v-layout row wrap>
                <v-flex xs8>
                        <div>
                            <h1 class="heading">Stay in touch</h1>

                        </div>

                </v-flex>

                <v-flex xs4>

                        <div class="secondary-heading text-center">
                            <h1>#OTEW</h1>
                            <p>Join the conversation online to get conference updates, industry tips, best practices and more. </p>
                        </div>

                </v-flex>
            </v-layout>

            <div class="container">
                <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="flip">
                        <div :class="this.twitter" @click="toggle('twitter')">

                            <div class="face front">
                                <div class="inner">
                                    <img src="images/touchscreen/twitter.png" height="100" width="100">
                                    <p>some text</p>
                                </div>
                            </div>
                            <div class="face back">

                                <generate-qr-code
                                        qr-code-text="https://twitter.com/intent/tweet"
                                ></generate-qr-code>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="flip">
                        <div :class="this.linkedin" @click="toggle('linkedin')">

                            <div class="face front">
                                <div class="inner">
                                    <img src="images/touchscreen/linkedin.png" height="100" width="100">
                                    <p>some text</p>
                                </div>
                            </div>
                            <div class="face back">

                                <generate-qr-code
                                        qr-code-text="https://twitter.com/intent/tweet"
                                ></generate-qr-code>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="flip">
                        <div :class="this.youtube" @click="toggle('youtube')">

                            <div class="face front">
                                <div class="inner">
                                    <img src="images/touchscreen/youtube.png" height="100" width="100">
                                    <p>some text</p>
                                </div>
                            </div>
                            <div class="face back">

                                <generate-qr-code
                                        qr-code-text="https://twitter.com/intent/tweet"
                                ></generate-qr-code>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="flip">
                        <div :class="this.google" @click="toggle('google')">

                            <div class="face front">
                                <div class="inner">
                                    <img src="images/touchscreen/google-plus.png" height="100" width="100">
                                    <p>some text</p>
                                </div>
                            </div>
                            <div class="face back">

                                <generate-qr-code
                                        qr-code-text="https://twitter.com/intent/tweet"
                                ></generate-qr-code>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            </div>
            </div>




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
    </v-container>
    </div>
</template>

<style>

    @import "https://cdn.jsdelivr.net/npm/animate.css@3.5.1";



    .heading{
        color:#2F3D98;
        font-size:100px;
        font-weight:bold;

    }

    .secondary-heading :not(h1){
       color:#121B58;
        font-weight:bold;
        text-align:left;
    }

    .flip {
        -webkit-perspective: 800;
        perspective: 800;
        position: relative;
        text-align: center;
    }
    .flip .card.flipped {
        -webkit-transform: rotatey(-180deg);
        transform: rotatey(-180deg);
    }
    .flip .card {
        width: 270px;
        height: 178px;
        -webkit-transform-style: preserve-3d;
        -webkit-transition: 0.5s;
        transform-style: preserve-3d;
        transition: 0.5s;
        background-color: #fff;

    }
    .flip .card .face {
        -webkit-backface-visibility: hidden ;
        backface-visibility: hidden ;
        z-index: 2;
    }
    .flip .card .front {
        position: absolute;
        width: 270px;
        z-index: 1;
    }
    .flip .card .front img{
        width: 60%;
        height: 60%;
    }
    .flip .card .img {
        position: relative;
        width: 100px;
        height: 100px;
        z-index: 1;
        border: 2px solid #000;
    }
    .flip .card .back {

        -webkit-transform: rotatey(-180deg);
        transform: rotatey(-180deg);

    }
    .inner{
        margin:0px !important;
        width: 270px;
    }

</style>

<script>
    export default {
        data() {

            return {
                youtube: "card",
                twitter: "card",
                linkedin: "card",
                google: "card",

            }
        },

        methods:{
            toggle(card){
                console.log(this.card);

                if(card=="linkedin")
                {
                    if(this.linkedin == "card")
                        this.linkedin = "card flipped"
                    else
                        this.linkedin = "card"
                }
                if(card=="youtube")
                {
                    if(this.youtube == "card")
                        this.youtube = "card flipped"
                    else
                        this.youtube = "card"
                }

                if(card=="google")
                {
                    if(this.google == "card")
                        this.google = "card flipped"
                    else
                        this.google = "card"
                }

                if(card=="twitter")
                {
                    if(this.twitter == "card")
                        this.twitter = "card flipped"
                    else
                        this.twitter = "card"
                }


            },
        }

    }
</script>