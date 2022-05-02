<template>
  <div>
    <div class="container-fluid bg-dark ms-auto my-5 p-5">
      <button
        type="button"
        class="btn btn-success mb-3"
        @click="addModal = true"
      >
        <i class="bi bi-plus-lg"></i>
        Esemény létrehozása
      </button>
      <table class="table table-striped table-light table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Időpont</th>
            <th scope="col">Név</th>
            <th scope="col">Leírás</th>
            <th scope="col">Létszám</th>
            <th scope="col">Térkép</th>
            <th scope="col">Funkciók</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(event, e) in events" :key="e">
            <th>{{ event.id }}</th>
            <td>{{ event.date }}</td>
            <td>{{ event.name }}</td>
            <td>{{ event.description }}</td>
            <td>{{ event.headcount }}</td>
            <td>{{ event.google_maps_iframe }}</td>
            <td>
              <div class="d-flex justify-content-start">
                <i
                  class="bi bi-pencil-fill edit-icon mx-2"
                  title="Szerkesztés"
                  @click="showEditModal(event)"
                ></i>
                <i
                  class="bi bi-trash3-fill delete-icon mx-2"
                  title="Törlés"
                  @click="showDeleteModal(event.id)"
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
      size="xl"
      title="Esemény létrehozása: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Név: </label>
        <input class="form-control" type="text" v-model="data.name" />
      </div>
      <div class="mb-3">
        <label class="form-label">Időpont: </label>
        <input
          class="form-control"
          type="datetime-local"
          v-model="data.dateTime"
        />
      </div>
      <div class="mb-3">
        <label class="form-label">Leírás: </label>
        <textarea
          class="form-control"
          rows="3"
          v-model="data.description"
        ></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Létszám: </label>
        <input
          class="form-control"
          type="number"
          min="1"
          v-model="data.headcount"
        />
      </div>
      <div class="mb-3">
        <label class="form-label">Helyszín: </label>
        <input class="form-control" type="text" v-model="data.location" />
      </div>
      <div class="mb-3">
        <label class="form-label"
          >Google Maps iframe:
          <span class="not-required">Nem kötelező!</span></label
        >
        <input class="form-control" type="text" v-model="data.googleMaps" />
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
    <b-modal
      v-model="addModal"
      size="xl"
      title="Esemény létrehozása: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Név: </label>
        <input class="form-control" type="text" v-model="data.name" />
      </div>
      <div class="mb-3">
        <label class="form-label">Időpont: </label>
        <input
          class="form-control"
          type="datetime-local"
          v-model="data.dateTime"
        />
      </div>
      <div class="mb-3">
        <label class="form-label">Leírás: </label>
        <textarea
          class="form-control"
          rows="3"
          v-model="data.description"
        ></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Létszám: </label>
        <input
          class="form-control"
          type="number"
          min="1"
          v-model="data.headcount"
        />
      </div>
      <div class="mb-3">
        <label class="form-label">Helyszín: </label>
        <input class="form-control" type="text" v-model="data.location" />
      </div>
      <div class="mb-3">
        <label class="form-label"
          >Google Maps iframe:
          <span class="not-required">Nem kötelező!</span></label
        >
        <input class="form-control" type="text" v-model="data.googleMaps" />
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
    <!-- Delete Modal -->
    <b-modal
      v-model="deleteModal"
      title="Biztosan törölni szeretné ezt az eseményt?"
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
        <button class="btn btn-danger mx-1" @click="deleteEvent">
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
      title="Esemény szerkesztése: "
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
        <label class="form-label">Időpont: </label>
        <input
          class="form-control"
          type="datetime-local"
          v-model="editData.dateTime"
        />
      </div>
      <div class="mb-3">
        <label class="form-label">Leírás: </label>
        <textarea
          class="form-control"
          rows="3"
          v-model="editData.description"
        ></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Létszám: </label>
        <input
          class="form-control"
          type="number"
          min="1"
          v-model="editData.headcount"
        />
      </div>
      <div class="mb-3">
        <label class="form-label">Helyszín: </label>
        <input class="form-control" type="text" v-model="editData.location" />
      </div>
      <div class="mb-3">
        <label class="form-label"
          >Google Maps iframe:
          <span class="not-required">Nem kötelező!</span></label
        >
        <input class="form-control" type="text" v-model="editData.googleMaps" />
      </div>
      <div class="d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-danger mx-2"
          @click="editModal = false"
        >
          Bezárás
        </button>
        <button type="button" :disabled="editing" class="btn btn-success mx-2">
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
      data: {
        name: "",
        dateTime: "",
        description: "",
        headcount: "",
        location: "",
        googleMaps: "",
        userId: "",
      },
      events: [],
      addModal: false,
      adding: false,
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
    };
  },
  methods: {
    async add() {
      if (this.data.name.trim() == "")
        return this.$toast.warning("Név megadása kötelező!");
      if (this.data.dateTime.trim() == "")
        return this.$toast.warning("Időpont megadása kötelező!");
      if (this.data.description.trim() == "")
        return this.$toast.warning("Leírás megadása kötelező!");
      if (this.data.headcount.trim() == "")
        return this.$toast.warning("Létszám megadása kötelező!");
      if (this.data.location.trim() == "")
        return this.$toast.warning("Helyszín megadása kötelező!");

      this.adding = true;

      this.data.userId = this.getUser.id;

      const res = await this.callApi("post", "/create_event", this.data);

      if (res.status == 201) {
        this.events.unshift(res.data);
        this.$toast.success("Esemény sikeresen létrehozva!");
      } else {
        this.$toast.error("Esemény létrehozása sikertelen!");
      }
      this.addModal = false;
      this.adding = false;
    },
    async getEvents() {
      const res = await this.callApi(
        "get",
        `/get_event?page=${this.currentPage}&itemPerPage=${this.itemPerPage}`
      );
      if (res.status == 200) {
        this.events = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Események betöltése sikertelen!");
      }
    },
    handlePageChange(value) {
      this.currentPage = value;
      this.getEvents();
    },
    showDeleteModal(id) {
      this.deleteModal = true;
      this.deleteId = id;
    },
    async deleteEvent() {
      this.deleting = true;
      const res = await this.callApi("post", "/delete_event", {
        id: this.deleteId,
      });

      if (res.status == 200) {
        this.$toast.success("Esemény sikeresen törölve!");
        this.events.splice(
          this.events.findIndex((item) => item.id == this.deleteId),
          1
        );
      } else {
        this.$toast.error(res.data.message);
      }
      this.deleteModal = false;
      this.deleteId = null;
      this.deleting = false;
    },
    showEditModal(event) {

      const obj = {
        name: event.name,
        dateTime: event.date.replace(" ", "T"),
        description: event.description,
        headcount: event.headcount,
        location: event.location,
        googleMaps: event.google_maps_iframe,
      };
      this.editData = obj;
      console.log(this.editData);
      this.editModal = true;
    },
    async edit(){
      const res = await this.callApi('post', 'edit_event', this.editData )
    }
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
  created() {
    this.getEvents();
  },
};
</script>