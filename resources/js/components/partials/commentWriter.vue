<template>
  <div>
    <textarea
      v-model="comment"
      class="form-control"
      id="exampleFormControlTextarea1"
      rows="3"
    ></textarea>
    <button type="button" class="btn btn-success">
      Küldés <i class="bi bi-send-fill"></i>
    </button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      comment: "",
    };
  },
  methods: {
    async sendComment() {
      const res = await this.callApi("post", "app/create_comment", {
        comment: this.comment,
      });
      if (res.status == 201) {
        this.$toast.success("Komment sikeresen elküldve");
        this.$emit('newComment', this.comment)
      } else {
        this.$toast.error("Komment elküldése sikertelen");
      }
    },
  },
};
</script>
