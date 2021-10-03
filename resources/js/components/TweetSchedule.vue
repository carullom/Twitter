<template>
    <div>

        
        <button @click="recupera_post">
            Recupera Post
        </button>

        <div v-for='tweet in tweets'>
            <h2>{{tweet.tweet}}</h2>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
 data:{
        tweets:[]
    },
    methods:{
        recupera_post(){
            axios.get('api/schedulepost')
            .then(function(risposta){
                console.log(risposta.data)
                app.tweets=risposta.data
            }
            )
        }
    }
        }
    }
</script>