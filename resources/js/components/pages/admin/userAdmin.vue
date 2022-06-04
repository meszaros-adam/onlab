<template>
  <div>
    <div class="container-fluid bg-dark ms-auto my-5 p-5">
      <div class="d-flex justify-content-end text-light">
        <h5 class="mx-3">Rendezés:</h5>
        <select
          v-model="orderBy"
          @change="getusers"
          class="form-select mb-4"
          style="width: auto"
          aria-label="Default select example"
        >
          <option value="id">Azonosító (ID)</option>
          <option value="name">Név</option>
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
          <tr v-for="(user, t) in users" :key="t">
            <th>{{ user.id }}</th>
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.is_admin ? 'Igen' : 'Nem' }}</td>
            <td>{{ user.created_at }}</td>
            <td>
              <div class="d-flex justify-content-start">
                <i
                  class="bi bi-pencil-fill edit-icon mx-2"
                  title="Szerkesztés"
                  @click="showEditModal(user, t)"
                ></i>
                <i
                  class="bi bi-trash3-fill delete-icon mx-2"
                  title="Törlés"
                  @click="showDeleteModal(user.id)"
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
    <!-- Delete Modal -->
    <b-modal
      v-model="deleteModal"
      title="Biztosan törölni szeretné ezt a felhasználót?"
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="text-center">
        <i class="bi bi-exclamation-circle-fill delete-warning"></i>
      </div>
      <div class="d-flex my-3 justify-content-end">
        <button @click="deleteModal = false" class="btn btn-success mx-1">
          Mégsem
        </button>
        <button class="btn btn-danger mx-1" @click="deleteuser">
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-show="deleting"
          ></span>
          <span class="sr-only">Törlés</span>
        </button>
      </div>
    </b-modal>
    <!-- Delete Modal -->
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
        <label class="form-label">Email: </label>
        <input class="form-control" type="text" v-model="editData.email" />
        <label class="form-label">Admin: </label>
        <select class="form-select"  v-model="editData.is_admin" aria-label="Default select example">
          <option :value="true">Igen</option>
          <option :value="false">Nem</option>
        </select>
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
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      users: [],
      orderBy: "id",
      //pagination
      itemPerPage: 10,
      currentPage: 1,
      total: 0,

      deleteId: null,
      deleteModal: false,
      deleting: false,

      editModal: false,
      editData: {},
      editing: false,
      editIndex: "",
    };
  },
  methods: {
    handlePageChange(value) {
      this.currentPage = value;
      this.getusers();
    },
    showDeleteModal(id) {
      this.deleteId = id;
      this.deleteModal = true;
    },
    async deleteuser() {
      this.deleting = true;
      const res = await this.callApi("post", "/app/delete_user", {
        id: this.deleteId,
      });

      if (res.status == 200) {
        this.$toast.success("Felhasználó sikeresen törölve!");
        this.users.splice(
          this.users.findIndex((item) => item.id == this.deleteId),
          1
        );
      } else {
        this.$toast.error(res.data.message);
      }
      this.deleteModal = false;
      this.deleteId = null;
      this.deleting = false;
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
    async getusers() {
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
    ...mapGetters(["getUser"]),
  },
  created() {
    this.getusers();
  },
};
</script>