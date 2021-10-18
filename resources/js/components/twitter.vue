
<template>


    <div class="container-fluid">
        <div class="row align-items-center color-twitter ">
            <div class="col-1 text-center ">
                <img :src="image" alt="" class="max-width:100%">
            </div>
            <div class="col-lg-11 col-sm-12">
                <h1>{{name}} </h1>
                <p>@{{nickname}}</p>
            
            </div>
                

      
        </div>
       
       
       

        <form  v-on:submit.prevent="input" >
            <div class="row mt-5 p-3">

            <div class="col-12">

                <div class="form-group">
                       
                    <h3>Inserisci testo</h3>
                    <textarea v-model="text" :maxlength=240 class="form-control"  id="text" rows="3" placeholder="Cosa c'è di vuovo?" required></textarea>
                </div>
                <div class="form-group mt-3">
                    <h3>Scegli una data</h3>
                    <b-form-datepicker id="data" v-model="data" class="mb-2"></b-form-datepicker>
                       
                </div>

                 <div class="form-group mt-3">
                    <h3>Scegli un'ora</h3>
                     <b-form-timepicker v-model="clock" locale="en"></b-form-timepicker>
                        
                </div>
                

                <div class="text-center m-3 mx-5">
                    <button type="submit" class="btn btn-lg  button mt-2 mx-2">Twitta</button>
                    <button class="btn btn-lg  button mt-2 mx-2" @click.prevent="inputschedule">Pianifica</button>

                </div>
                

                <div v-if="error!=''">  
                    <h3 class="text-danger text-center">{{error}}</h3>
                </div>

            </div>

            </div>
        </form>
    
    
       
        
        <h2 class="mt-5">Post programmati:</h2>
        <hr>

        <div class="row justify-content-center" >
            <div class="col-10">
                  <div v-for="tweet in tweets" :key="tweet.tweet" class="card my-5 animate__animated animate__zoomIn">
                    <div class="card-header color-twitter">
                         @{{nickname}}
                    </div>
                    <div class="card-body">
                
                            <h3>{{tweet.tweet}}</h3>
                            <footer class="footer mt-2"><p>Sarà pubblicato giorno: {{tweet.schedule_at}}</p></footer>
                       
                    </div>
                </div>
            </div>
        </div>

         <h2 class="mt-5">Post pubblicati:</h2>
         <hr>

        <div class="row justify-content-center">
            <div class="col-10">
                  <div v-for="post in posts" :key="post.text" class="card my-5 animate__animated animate__zoomIn">
                    <div class="card-header color-twitter">
                         @{{nickname}}
                    </div>
                    <div class="card-body">
                       
                            <h3>{{post.text}}</h3>
                            <footer class="footer mt-2"><p class="">{{post.created_at}}</p></footer>
                       
                    </div>
                </div>
            </div>
        </div>
      

       

    </div>
</template>

<script>
    export default {
        mounted() {
         this.post_schedule(),
         this.post_public(),
         this.user()

        },
   
    data(){ 
        return{
             tweets:[],
             text:'',
            schedule_at:'',
            posts:[],
            name:'',
            nickname:'',
            image:'',
            clock:'',
            data:'',
            error:''
        }
      
    },
    methods:{
        //metodo che richiama i post programmati e li inserisce nella variabile tweets
        async post_schedule(){
        await axios.get('api/schedulepost')
        .then((response) => {
        this.error = ''
        this.tweets = response.data
        
        })
            },

        //metodo che permette di inserire un post e pubblicarlo su twitter
        async input(){
            await axios.post('api/insert',{
                    tweet:this.text
            })
            .then((response)=>{
                
                this.post_public()

            })
            this.text=''
        },


        //metodo che permette di programmare un post
       async inputschedule(){
          axios.post('api/schedule',{
            tweet:this.text,
            schedule_at:this.data+' '+this.clock
            })
        .then((response) => {
            this.error = ''
            this.post_schedule()
        })
        .catch((response)=>{
                this.error='Il post non può essere pianificato per questa data'
        })
        
        this.data=''
        this.clock=''
        this.text=''
        },

        //metodo che richiama i post già pubblicati su twitter
        async post_public(){
         await axios.get('api/tweet')
         .then((response) => {
             this.posts=response.data
         
             })
        },

        //metodo che richiama i dati dell'utente
        async user(){
            await axios.get('api/user')
            .then((response) => {
            this.name=response.data.name
            this.nickname=response.data.screen_name
            this.image=response.data.profile_image_url
             })
        },

  
    }
}
    
</script>

<style>
.color-twitter{
    background-color:#1a8cd8;
    color:white;
}

.button{
    background-color:#1a8cd8;
    color:white;
    border-radius: 20%;
}
img {
  border-radius: 50%;
 
}

.button:hover {
    background-color:rgb(57, 98, 117);
    color:#1a8cd8;
}
</style>
