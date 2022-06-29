<template>
  <div>
    <h1 class="comments-headline my-5">Kommentek</h1>
    <div>
      <div v-if="commentTree.length > 0">
        <comment
          class="mb-3 comment p-2 rounded"
          @newComment="newComment"
          v-for="c in commentTree"
          :key="c.id"
          :comment="c"
        ></comment>
      </div>
      <div v-else>
        <h4>Légy te az első hozzászóló!</h4>
      </div>
    </div>
    <comment-writer
      :event_id="event_id"
      :parent_comment_id="null"
      @newComment="newComment"
    ></comment-writer>
  </div>
</template>

<script>
import comment from "./comment.vue";
import commentWriter from "./commentWriter.vue";

export default {
  props: ["event_id"],
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
    async getComments() {
      const res = await this.callApi(
        "get",
        `/app/get_comment_by_event?event_id=${this.event_id}`
      );

      if ((res.status = 200)) {
        this.commentsFlatArray = res.data;
        this.createTree();
      } else {
        this.$toast.error("Kommentek betöltése sikertelen");
      }
    },
    createTree() {
      //this function creates a tree
      const nest = (items, id = null, link = "parent_comment_id") =>
        items
          .filter((item) => item[link] === id)
          .map((item) => ({ ...item, children: nest(items, item.id) }));
      //this function creates a tree

      this.commentTree = nest(this.commentsFlatArray);
    },
    newComment(newComment) {
      this.commentTree.push(newComment);
    },
  },
  created() {
    this.getComments();
  },
};
</script>