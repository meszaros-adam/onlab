<template>
  <b-modal
    v-model="getDeleteModalObj.showDeleteModal"
    :title="getDeleteModalObj.msg"
    hide-header-close
    hide-footer
    no-close-on-esc
    no-close-on-backdrop
  >
    <div class="text-center">
      <i class="bi bi-exclamation-circle-fill delete-warning"></i>
    </div>
    <div class="d-flex my-3 justify-content-end">
      <button @click="cancel" class="btn btn-success mx-1">Mégsem</button>
      <button class="btn btn-danger mx-1" @click="deleteItem">
        <span
          class="spinner-border spinner-border-sm"
          role="status"
          aria-hidden="true"
          v-show="getDeleteModalObj.isDeleting"
        ></span>
        <span class="sr-only">Törlés</span>
      </button>
    </div>
  </b-modal>
</template>
<script>
import { mapGetters } from "vuex";
export default {
  data() {
    return {
      isDeleting: false,
    };
  },
  methods: {
    async deleteItem() {
      const deletingModalObj = {
        showDeleteModal: false,
        deleteUrl: "",
        data: null,
        deletingIndex: this.getDeleteModalObj.deletingIndex,
        isDeleted: true,
      };

      this.isDeleting = true;

      const res = await this.callApi(
        "post",
        this.getDeleteModalObj.deleteUrl,
        this.getDeleteModalObj.data
      );

      if(res.status == 200 && this.getDeleteModalObj.deleteUrl == '/app/delete_user_by_user' ){
        window.location.href = '/'
      }
      else if (res.status == 200 ) {
        this.$toast.success(this.getDeleteModalObj.successMsg);
        this.$store.commit("setDeleteModalObj", deletingModalObj);
      }else {
        this.$toast.error("Törlés sikertelen");
      }
      this.isDeleting = false;
    },
    //set deleting modal object to default, after cancel
    cancel() {
      const deletingModalObj = {
        showDeleteModal: false,
        deleteUrl: "",
        data: null,
        deletingIndex: -1,
        isDeleted: false,
        objecType: "",
        msg: "",
        successMsg: "",
      };
      this.$store.commit("setDeleteModalObj", deletingModalObj);
    },
  },
  computed: {
    ...mapGetters(["getDeleteModalObj"]),
  },
};
</script>