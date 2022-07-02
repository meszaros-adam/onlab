<template>
  <div class="container-fluid bg-dark ms-auto my-5 p-5">
    <table class="table table-striped table-light table-hover">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Felhasználó</th>
          <th scope="col">Esemény</th>
          <th scope="col">Komment</th>
          <th scope="col">Létrehozva</th>
          <th scope="col">Funkciók</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(comment, c) in comments" :key="c">
          <th>{{ comment.id }}</th>
          <th>{{ comment.user.email }}</th>
          <td>{{ comment.event.name }}</td>
          <td>{{ comment.comment }}</td>
          <td>{{ comment.created_at }}</td>
          <td>
            <div class="d-flex justify-content-start">
              <i
                class="bi bi-pencil-fill edit-icon mx-2"
                title="Szerkesztés"
                @click="showEditModal(comment, c)"
              ></i>
              <i
                class="bi bi-trash3-fill delete-icon mx-2"
                title="Törlés"
                @click="showDeleteModal(comment.id, c)"
              ></i>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Pagination -->
    <b-pagination
      v-model="currentPage"
      :total-rows="total"
      :per-page="itemPerPage"
      align="center"
      @change="handlePageChange"
    ></b-pagination>
    <!-- Pagination -->
    <!-- Edit Modal -->
    <b-modal
      v-model="editModal"
      title="Komment szerkesztése: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Komment: </label>
        <textarea class="form-control" rows="4" v-model="editData.comment">
        </textarea>
      </div>
      <div class="d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-danger mx-2"
          @click="editModal = false"
        >
          Bezárás
        </button>
        <button
          type="button"
          :disabled="editing"
          @click="edit"
          class="btn btn-success mx-2"
        >
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-show="editing"
          ></span>
          <span class="sr-only">Mentés</span>
        </button>
      </div>
    </b-modal>
    <!-- Edit Modal -->
    <deleteModal> </deleteModal>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import deleteModal from "./deleteModal.vue";

export default {
  components: { deleteModal },
  props: ["getUrl"],
  data() {
    return {
      comments: [],

      orderBy: "id",
      //pagination
      itemPerPage: 10,
      currentPage: 1,
      total: 0,

      editModal: false,
      editData: {},
      editing: false,
      editIndex: "",
    };
  },
  methods: {
    handlePageChange(value) {
      this.currentPage = value;
      this.getComments();
    },
    showDeleteModal(id, index) {
      const deleteModalObj = {
        showDeleteModal: true,
        deleteUrl: "/app/delete_comment",
        data: { id: id },
        deletingIndex: index,
        msg: "Biztosan törölni akarja ezt a kommentet?",
        successMsg: "Komment sikeresen törölve!",
      };
      this.$store.commit("setDeleteModalObj", deleteModalObj);
    },
    showEditModal(comment, index) {
      const obj = {
        id: comment.id,
        comment: comment.comment,
      };
      this.editData = obj;
      this.editIndex = index;
      this.editModal = true;
    },
    async edit() {
      if (this.editData.comment.length == 0)
        return this.$toast.warning("Komment megadása kötelező!");

      this.editing = true;

      const res = await this.callApi(
        "post",
        "/app/edit_comment",
        this.editData
      );

      if (res.status == 200) {
        this.comments[this.editIndex].comment = this.editData.comment;
        this.$toast.success("Komment sikeresen szerkesztve!");
      } else {
        this.$toast.error("Komment szerkesztése sikertelen!");
      }

      this.editing = false;
      this.editModal = false;
    },
    async getComments() {
      const res = await this.callApi(
        "get",
        `${this.getUrl}?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}`
      );
      if (res.status == 200) {
        this.comments = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Kommentek betöltése sikertelen!");
      }
    },
  },
  created() {
    this.getComments();
  },
  computed: {
    ...mapGetters(["getUser", "getDeleteModalObj"]),
  },
  watch: {
    getDeleteModalObj(obj) {
      if (obj.isDeleted) {
        this.comments.splice(obj.deletingIndex, 1);
      }
    },
  },
};
</script>