<template>
    <transition name="router-anim" enter-active-class="animated bounceIn" leave-active-class="animated fadeOutDown">


     <div class="col-md-12 nav">



        <v-container grid-list-md text-xs-center>



            <div class="row">

                <table>
                    <tr>
                        <td class="tile"> <a href="#/Agenda"> <nav-tiles :img="'agenda.png'" :caption="'Agenda'"></nav-tiles></a></td>
                        <td class="tile"> <a href="#/Map"><nav-tiles :img="'map.png'" :caption="'Map'"></nav-tiles></a></td>
                        <td class="tile"> <a href="#/Expo"><nav-tiles :img="'expo.png'" :caption="'Expo'"></nav-tiles></a></td>
                        <td class="tile"> <a href="#/Events"><nav-tiles :img="'events.png'" :caption="'Events'"></nav-tiles></a></td>
                        <td class="tile"> <a href="#/Social"> <nav-tiles :img="'social.png'" :caption="'Social'"></nav-tiles> </a></td>
                        <td class="tile"> <nav-tiles :img="'ew-games.png'" :caption="'EW Games'"></nav-tiles> </td>
                        <td class="tile"> <nav-tiles :img="'sponsors.png'" :caption="'Sponsors'"></nav-tiles> </td>
                    </tr>
                </table>



            </div>
        </v-container>




    </div>
    </transition>
</template>

<script>
    export default{
        props:['classs']
    }
</script>
<style>
    @import "https://cdn.jsdelivr.net/npm/animate.css@3.5.1";

    .nav{
        top:18vh;
    }

    .drawer{
        background-color: white;
    }

    a{
        text-decoration: none;
    }

    #sec{
        //background-color: red;
        width:100%;

    }

    table{
        border-spacing: 10px;
        border-collapse: separate;

    }

    .tile{
        width:11.28vw;
    }



</style>