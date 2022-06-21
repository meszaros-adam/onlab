<template>
  <div>
    <p></p>
    <button type="button" class="btn btn-success">
      Válasz <i class="bi bi-reply"></i>
    </button>
    <comment-writer v-if(showReply) @newComment="newComment"></comment-writer>
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
            this.$emmit('newComment', comment)
        }
    }
}
</script>