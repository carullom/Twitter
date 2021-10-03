
<template>

    <div>

        
        <h1>Ecco i post:</h1>

      <div v-for="tweet in tweets" :key="tweet.tweet">
          <h2>{{tweet.tweet}}</h2>
      </div>
            
       

    </div>
</template>

<script>
    export default {
        mounted() {
         this.recupera_post()
        },
   
    data(){ 
        return{
             tweets:[]
        }
       
    },
    methods:{
        async recupera_post(){
     await axios.get('api/schedulepost')
     .then((response) => {
       console.log(response.data)
       this.tweets = response.data
     })
            }
        }
    }
    
</script>
