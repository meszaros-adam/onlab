<template>
  <div class="ms-3">
    <div class="mb-2 comment-item">
      <div class="d-flex justify-content-between comment-info mb-3">
        <div>
          {{ comment.user.name }}
        </div>
        <div>
          {{ comment.created_at }}
        </div>
      </div>
      <p>{{ comment.comment }}</p>
      <div class="text-end">
        <button
          type="button"
          @click="showReplyWriter = !showReplyWriter"
          class="btn btn-success btn-sm"
        >
          Válasz <i class="bi bi-reply"></i>
        </button>
      </div>
      <comment-writer
        :event_id="comment.event_id"
        :parent_comment_id="comment.id"
        v-if="showReplyWriter"
        @newComment="handleReply"
      ></comment-writer>
    </div>
    <div v-if="comment.children.length > 0">
      <comment
        v-for="c in comment.children"
        :key="c.id"
        :comment="c"
      ></comment>
    </div>
  </div>
</template>

<script>
import commentWriter from "./commentWriter.vue";
export default {
  name: "comment",
  props: ["comment"],
  components: {
    commentWriter,
  },
  data() {
    return {
      showReplyWriter: false,
    };
  },
  methods: {
    handleReply(reply) {
      this.showReplyWriter = false;
      this.comment.children.unshift(reply)
    },
  },
};
</script>