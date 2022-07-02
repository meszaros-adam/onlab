<template>
  <comments getUrl="/app/get_comments"></comments>
</template>

<script>
import comments from "../../partials/commentsTable.vue";
export default {
  components: { comments },
};
</script>