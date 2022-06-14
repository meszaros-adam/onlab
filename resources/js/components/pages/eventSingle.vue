<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded"></div>
</template>

<script>
export default {

  created() {
    console.log(this.$route.params.id);
  },
};
</script>