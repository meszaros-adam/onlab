<template>
  <div>
    <div class="container-fluid bg-dark text-light ms-auto my-5 p-5">
      <h1>Felhasználók</h1>
      <div class="d-flex justify-content-end text-light">
        <h5 class="mx-3">Rendezés:</h5>
        <select
          v-model="orderBy"
          @change="getUsers"
          class="form-select mb-4"
          style="width: auto"
          aria-label="Default select example"
        >
          <option value="id">Azonosító (ID)</option>
          <option value="name">Név</option>
          <option value="email">Email cím</option>
        </select>
      </div>
      <table class="table table-striped table-light table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Név</th>
            <th scope="col">Email</th>
            <th scope="col">Admin</th>
            <th scope="col">Létrehozva</th>
            <th scope="col">Funkciók</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, u) in users" :key="u">
            <th>{{ user.id }}</th>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.is_admin ? "Igen" : "Nem" }}</td>
            <td>{{ user.created_at }}</td>
            <td>
              <div class="d-flex justify-content-start">
                <i
                  class="bi bi-pencil-fill edit-icon mx-2"
                  title="Szerkesztés"
                  @click="showEditModal(user, u)"
                ></i>
                <i
                  class="bi bi-trash3-fill delete-icon mx-2"
                  title="Törlés"
                  @click="showDeleteModal(user.id, u)"
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
    <!-- Edit Modal -->
    <b-modal
      v-model="editModal"
      size="xl"
      title="Felhasználó szerkesztése: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Név: </label>
        <input class="form-control" type="text" v-model="editData.name" />
      </div>
      <div class="mb-3">
        <label class="form-label">Email: </label>
        <input class="form-control" type="text" v-model="editData.email" />
      </div>
      <div class="mb-3">
        <div class="form-check form-switch">
          <input
            class="form-check-input user-admin me-2"
            type="checkbox"
            role="switch"
            id="flexSwitchCheckDefault"
            v-model="editData.is_admin"
          />
          <label class="form-check-label" for="flexSwitchCheckDefault"
            >Admin jogosultság</label
          >
        </div>
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

export default {
  components: { deleteModal },
  data() {
    return {
      users: [],
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
      this.getUsers();
    },
    showDeleteModal(id, index) {
      const deleteModalObj = {
        showDeleteModal: true,
        deleteUrl: "/app/delete_user",
        data: { id: id },
        deletingIndex: index,
        msg: "Biztosan törölni akarja ezt a felhasználót?",
        successMsg: "Felhasználó sikeresen törölve!",
      };
      this.$store.commit("setDeleteModalObj", deleteModalObj);
    },
    showEditModal(user, index) {
      const obj = {
        id: user.id,
        name: user.name,
        email: user.email,
        is_admin: user.is_admin,
      };
      this.editData = obj;
      this.editIndex = index;
      this.editModal = true;
    },
    async edit() {
      if (this.editData.name.trim() == "")
        return this.$toast.warning("Név megadása kötelező!");
      if (this.editData.name.trim() == "")
        return this.$toast.warning("Email cím megadása kötelező!");

      this.editing = true;

      const res = await this.callApi("post", "/app/edit_user", this.editData);

      if (res.status == 200) {
        this.users[this.editIndex] = this.editData;
        this.$toast.success("Felhasználó sikeresen szerkesztve!");
      } else {
        this.$toast.error("Felhasználó szerkesztése sikertelen!");
      }

      this.editing = false;
      this.editModal = false;
    },
    async getUsers() {
      const res = await this.callApi(
        "get",
        `/app/get_users?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}`
      );
      if (res.status == 200) {
        this.users = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Felhasználók betöltése sikertelen!");
      }
    },
  },
  computed: {
    ...mapGetters(["getUser", "getDeleteModalObj"]),
  },
  created() {
    this.getUsers();
  },
  watch: {
    getDeleteModalObj(obj) {
      if (obj.isDeleted) {
        this.users.splice(obj.deletingIndex, 1);
      }
    },
  },
};
</script>