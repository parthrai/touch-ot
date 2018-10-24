<template>

    <div>

        <div v-if="isValidated==false">
            <div class="alert alert-danger">
                <strong>Error!</strong> Please enter valid data.
            </div>
        </div>

        <div v-if="isSubmit">
            <h1>Feedback Received!</h1>

            <div class="text-center">
            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 98.5 98.5" enable-background="new 0 0 98.5 98.5" xml:space="preserve" height="100" width="100">
  <path class="checkmark" fill="none" stroke-width="8" stroke-miterlimit="10" d="M81.7,17.8C73.5,9.3,62,4,49.2,4
	C24.3,4,4,24.3,4,49.2s20.3,45.2,45.2,45.2s45.2-20.3,45.2-45.2c0-8.6-2.4-16.6-6.5-23.4l0,0L45.6,68.2L24.7,47.3"/>
</svg>
            </div>

        </div>

        <transition name="fade" v-else>

        <form  class="form-horizontal" action="#">

            <div class="form-group">
                <label class="control-label col-sm-2" >Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control form-fields" v-model="data.name"  placeholder="Enter your name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" >Email:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control form-fields"  v-model="data.email" placeholder="Enter your email">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" >Comment:</label>
                <div class="col-sm-10">
                    <textarea class="form-control form-fields" cols="50" rows="6" v-model="data.comment" placeholder="Comment">

                    </textarea>

                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success" @click="submitData">Submit</button>
                </div>
            </div>

        </form>
        </transition>
    </div>

</template>


<script>
    export default{

        data(){
            return{

                isSubmit:false,
                isValidated:true,
                data:{
                    name:'',
                    email:'',
                    comment:'',


                },
            }
        },

        methods:{

            validateData(){
                if(this.data.name=='' || this.data.email=='' || this.data.comment=='')
                    return false;
                else
                    return true;
            },

            submitData(){

                let validation = this.validateData();

                if(validation){
                    axios.post('http://dev.test/SubmitFeedback',this.data)
                        .then(response => {
                            console.log(response);

                        });

                    this.isSubmit=true;

                    let ref=this;

                    setTimeout(function (){
                        ref.isSubmit=false;
                    },5000);

                    this.isValidated=true;

                    this.data.name=''
                    this.data.email=''
                    this.data.comment=''

                }
                else{
                    this.isValidated=false;
                }

            }
        }

    }



</script>



<style>
    .form-fields{
        width: 85%;
    }

    .checkmark {
        stroke: green;
        stroke-dashoffset: 745.74853515625;
        stroke-dasharray: 745.74853515625;
        animation: dash 2s ease-out forwards infinite;
    }

    @keyframes dash {
        0% {
            stroke-dashoffset: 745.74853515625;
        }
        100% {
            stroke-dashoffset: 0;
        }
    }

    .fade-enter-active{
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>