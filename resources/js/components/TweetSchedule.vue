
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
       
       
       

        <form>
            <div class="row mt-5 p-3">

            <div class="col-12">

                <div class="form-group">
                    <h3>Inserisci testo</h3>
                    <textarea v-model="text" class="form-control"    id="text" rows="3" placeholder="Cosa c'è di vuovo?"></textarea>
                </div>
                <div class="form-group mt-3">
                    <h3>Scegli una data</h3>
                    <input v-model="schedule_at" type="text" class="form-control" id="schedule_at" name="schedule_at" placeholder="0000-00-00 00:00">
                </div>
                <div class="text-center m-3 mx-5">
                    <button type="submit" class="btn btn-lg  button mt-2" @click="input">Twitta</button>
                    <button type="submit" class="btn btn-lg  button mt-2" @click="inputschedule">Pianifica</button>

                </div>

            </div>

            </div>
        </form>
    
       

    
        
        <h2 class="mt-5">Post programmati:</h2>
        <hr>

        <div class="row justify-content-center" >
            <div class="col-10">
                  <div v-for="tweet in tweets" :key="tweet.tweet" class="card my-5">
                    <div class="card-header color-twitter">
                         Twitter
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
                  <div v-for="post in posts" :key="post.text" class="card my-5">
                    <div class="card-header color-twitter">
                         Twitter
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
            image:''
        }
      
    },
    methods:{
        //metodo che richiama i post programmati e li inserisce nella variabile tweets
        async post_schedule(){
        await axios.get('api/schedulepost')
        .then((response) => {
        this.tweets = response.data
        })
            },

        //metodo che permette di inserire un post e pubblicarlo su twitter
        async input(){
            await axios.post('api/insert',{
                    tweet:this.text
            })
            .then((response)=>{
                console.log(response)
            })
        },

        //metodo che permette di programmare un post
        async inputschedule(){
        await axios.post('api/schedule',{
                tweet:this.text,
                schedule_at:this.schedule_at
        })
        .then((response)=>{
            console.log(response)
        })
        },

        //metodo che richiama i post già pubblicati su twitter
        async post_public(){
         await axios.get('api/tweet')
         .then((response) => {
             console.log(response.data)
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
</style>
