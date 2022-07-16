<template>
  <div>
    <div class="container-fluid bg-dark text-light ms-auto my-5 p-5">
      <h1>Címkék</h1>
      <div class="d-flex text-light  align-items-center my-3">
        <button
          type="button"
          class="btn btn-success me-auto"
          @click="addModal = true"
        >
          <i class="bi bi-plus-lg"></i>
          Címke létrehozása
        </button>
        <h5 class="mx-3">Rendezés:</h5>
        <select
          v-model="orderBy"
          @change="getTags"
          class="form-select"
          style="width: auto"
          aria-label="Default select example"
        >
          <option value="id">Azonosító (ID)</option>
          <option value="name">Név</option>
        </select>
        <ordering v-model="ordering" @click.native="getTags"> </ordering>
      </div>
      <table class="table table-striped table-light table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Név</th>
            <th scope="col">Létrehozva</th>
            <th scope="col">Funkciók</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(tag, t) in tags" :key="t">
            <th>{{ tag.id }}</th>
            <td>{{ tag.name }}</td>
            <td>{{ tag.created_at }}</td>
            <td>
              <div class="d-flex justify-content-start">
                <i
                  class="bi bi-pencil-fill edit-icon mx-2"
                  title="Szerkesztés"
                  @click="showEditModal(tag, t)"
                ></i>
                <i
                  class="bi bi-trash3-fill delete-icon mx-2"
                  title="Törlés"
                  @click="showDeleteModal(tag.id, t)"
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
    </div>
    <!-- Adding Modal -->
    <b-modal
      v-model="addModal"
      title="Címke létrehozása: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Név: </label>
        <input class="form-control" type="text" v-model="data.name" />
      </div>
      <div class="d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-danger mx-2"
          @click="addModal = false"
        >
          Bezárás
        </button>
        <button
          type="button"
          :disabled="adding"
          class="btn btn-success mx-2"
          @click="add"
        >
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-show="adding"
          ></span>
          <span class="sr-only">Mentés</span>
        </button>
      </div>
    </b-modal>
    <!-- Adding Modal -->
    <!-- Edit Modal -->
    <b-modal
      v-model="editModal"
      title="Címke szerkesztése: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Név: </label>
        <input class="form-control" type="text" v-model="editData.name" />
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
    <deleteModal></deleteModal>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import deleteModal from "../../partials/deleteModal.vue";
import ordering from "../../partials/ordering.vue";

export default {
  components: { deleteModal, ordering },
  data() {
    return {
      data: {
        name: "",
      },
      tags: [],
      addModal: false,
      adding: false,
      orderBy: "id",
      ordering: 'desc',

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
    async add() {
      if (this.data.name.trim() == "")
        return this.$toast.warning("Név megadása kötelező!");

      this.adding = true;

      const res = await this.callApi("post", "/app/create_tag", this.data);

      if (res.status == 201) {
        this.tags.unshift(res.data);
        this.$toast.success("Címke sikeresen létrehozva!");
      } else {
        this.$toast.error("Címke létrehozása sikertelen!");
      }
      this.addModal = false;
      this.data.name = "";
      this.adding = false;
    },
    handlePageChange(value) {
      this.currentPage = value;
      this.getTags();
    },
    showDeleteModal(id, index) {
      const deleteModalObj = {
        showDeleteModal: true,
        deleteUrl: "/app/delete_tag",
        data: { id: id },
        deletingIndex: index,
        msg: "Biztosan törölni akarja ezt a címkét?",
        successMsg: "Címke sikeresen törölve!",
      };
      this.$store.commit("setDeleteModalObj", deleteModalObj);
    },
    showEditModal(tag, index) {
      const obj = {
        id: tag.id,
        name: tag.name,
      };
      this.editData = obj;
      this.editIndex = index;
      this.editModal = true;
    },
    async edit() {
      if (this.editData.name.trim() == "")
        return this.$toast.warning("Név megadása kötelező!");

      this.editing = true;

      const res = await this.callApi("post", "/app/edit_tag", this.editData);

      if (res.status == 200) {
        this.tags[this.editIndex] = this.editData;
        this.$toast.success("Címke sikeresen szerkesztve!");
      } else {
        this.$toast.error("Címke szerkesztése sikertelen!");
      }

      this.editing = false;
      this.editModal = false;
    },
    async getTags() {
      const res = await this.callApi(
        "get",
        `/app/get_tags?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}&ordering=${this.ordering}`
      );
      if (res.status == 200) {
        this.tags = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Címke betöltése sikertelen!");
      }
    },
  },
  computed: {
    ...mapGetters(["getUser", "getDeleteModalObj"]),
  },
  created() {
    this.getTags();
  },
  watch: {
    getDeleteModalObj(obj) {
      if (obj.isDeleted) {
        this.tags.splice(obj.deletingIndex, 1);
      }
    },
  },
};
</script>