<template></template>

<script>
export default {
  props: ["comments"],
  data() {
    return {
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
  },
  created: {
    createTree();
  }
};
</script>