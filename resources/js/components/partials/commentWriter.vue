<template>
  <div>
    <textarea
      v-model="data.comment"
      class="form-control my-3"
      id="exampleFormControlTextarea1"
      rows="3"
    ></textarea>
    <div class="text-end">
      <button @click="sendComment" type="button" class="btn btn-success">
        Küldés <i class="bi bi-send-fill"></i>
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["event_id"],
  data() {
    return {
      data: {
        comment: "",
        eventId: null,
      },
    };
  },
  methods: {
    async sendComment() {
      const res = await this.callApi("post", "/app/create_comment", this.data);
      if (res.status == 201) {
        this.$toast.success("Komment sikeresen elküldve");
        this.$emit("newComment", this.comment);
      } else {
        this.$toast.error("Komment elküldése sikertelen");
      }
    },
  },
  created() {
    this.data.eventId = this.event_id;
  },
};
</script>
