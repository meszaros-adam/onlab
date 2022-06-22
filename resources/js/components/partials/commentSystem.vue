<template>
  <div>
    <h1 class="comments-headline">Kommentek</h1>
    <div>
      <div v-if="commentsFlatArray.length > 0">
        <comment
          @newComment="newComment"
          v-for="comment in this.commentTree"
          :key="comment.id"
          :comment="comment"
        ></comment>
      </div>
      <div v-else>
        <h4>Légy te az első hozzászóló!</h4>
      </div>
    </div>
    <comment-writer :event_id="event_id" @newComment="newComment"></comment-writer>
  </div>
</template>

<script>
import comment from "./comment.vue";
import commentWriter from "./commentWriter.vue";

export default {
  props: ["comments", 'event_id'],
  components: {
    comment,
    commentWriter,
  },
  data() {
    return {
      commentsFlatArray: [],
      commentTree: [],
    };
  },
  methods: {
    createTree() {
      //this function creates a tree
      const nest = (items, id = null, link = "parent_comment_id") =>
        items
          .filter((item) => item[link] === id)
          .map((item) => ({ ...item, children: nest(items, item.id) }));
      //this function creates a tree

      this.commentTree = nest(this.comments);
    },
    newComment(comment) {
      this.commentsFlatArray.push(comment);
      this.createTree();
    },
  },
  created() {
    this.commentsFlatArray = this.comments;
    this.createTree();
  },
};
</script>