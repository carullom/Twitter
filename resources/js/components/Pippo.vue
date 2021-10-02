<template>
 
    <ul class="list-group">
        <li class="list-group-item" v-for="tweet in tweets">{{tweet.text}}</li>
  
</ul>

</template>

<script>
    export default {
        data: function(){
            return{
                tweets:[]
            }
        },
        mounted(){
            this.loadtweet
        },
        method:{
            loadtweet:function(){
                axios.get('/api/tweet')
                .then((response)=>{
                    this.tweets=response.data.data;
                )}
            }
        }


    }
</script>



