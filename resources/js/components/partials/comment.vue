<template>
  <div>
    <p>{{comment.comment}}</p>
    <button type="button" @click="showReply=!showReply" class="btn btn-success">
      Válasz <i class="bi bi-reply"></i>
    </button>
    <comment-writer :event_id="comment.event_id" v-if="showReply" @newComment="newComment"></comment-writer>
  </div>
</template>

<script>
import commentWriter from "./commentWriter.vue"
export default {
    props: ['comment'],
    components:{
        commentWriter,
    },
    data(){
        return{
            showReply: false,
        }
    },
    methods:{
        newComment(comment){
            this.$emit('newComment', comment)
        }
    }
}
</script>