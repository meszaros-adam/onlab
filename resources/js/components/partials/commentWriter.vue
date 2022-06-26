<template>
  <div>
    <div v-if="getUser">
      <textarea
        v-model="comment"
        class="form-control my-3"
        id="exampleFormControlTextarea1"
        rows="3"
      ></textarea>
      <div class="text-end">
        <button @click="sendComment" type="button" class="btn btn-success btn-sm">
          Küldés <i class="bi bi-send-fill"></i>
        </button>
      </div>
    </div>
    <div v-else>
      <router-link to="/login">
        <button type="button" class="btn btn-warning my-4">
          Jelentkezz be a hozzászóláshoz!
        </button></router-link
      >
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
export default {
  props: ["event_id", "parent_comment_id"],
  data() {
    return {
      comment: "",
    };
  },
  methods: {
    async sendComment() {
      const res = await this.callApi("post", "/app/create_comment", {
        comment: this.comment,
        event_id: this.event_id,
        parent_comment_id: this.parent_comment_id,
      });
      if (res.status == 201) {
        this.comment = "";
        this.$toast.success("Komment sikeresen elküldve");
        this.$emit("newComment");
      } else {
        this.$toast.error("Komment elküldése sikertelen");
      }
    },
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
};
</script>
