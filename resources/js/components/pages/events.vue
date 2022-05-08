<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
      <div class="col mb-4" v-for="(event, e) in events" :key="e">
        <div class="card text-dark">
          <div class="card-body">
            <h5 class="card-title">{{ event.name }}</h5>
            <p class="card-text">{{ event.description }}</p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Időpont: {{ event.date }}</li>
            <li class="list-group-item">Helyszín: {{ event.location }}</li>
            <li class="list-group-item">
              <strong>Létszám: {{ event.headcount }}</strong>
            </li>
            <li class="list-group-item">
              <strong>Szabad helyek: {{ event.free_seats }}</strong>
            </li>
          </ul>
          <div class="card-body text-end">
            <button class="button btn btn-success" @click="showRegModal(event)">
              Regisztrálás
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Pagination -->
    <b-pagination
      v-model="currentPage"
      :total-rows="total"
      :per-page="itemPerPage"
      align="center"
      @change="handlePageChange"
    ></b-pagination>
    <!-- Pagination -->

    <!-- Registration model-->
    <b-modal
      v-model="regModal"
      title="Regisztráció: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Hány fővel szeretne regisztrálni? </label>
        <input
          v-if="regModal"
          class="form-control"
          type="number"
          min="1"
          :max="regEvent.free_seats"
          v-model="data.headcount"
        />
      </div>

      <div class="d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-danger mx-2"
          @click="closeRegModal()"
        >
          Bezárás
        </button>
        <button
          type="button"
          :disabled="registrating"
          @click="register()"
          class="btn btn-success mx-2"
        >
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-show="registrating"
          ></span>
          <span class="sr-only">Regisztráció</span>
        </button>
      </div>
    </b-modal>
    <!-- Registration model-->
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      data: {
        headcount: "",
        userId: null,
        eventId: null,
      },
      events: [],

      //pagination
      itemPerPage: 10,
      currentPage: 1,
      total: 0,

      regModal: false,
      registrating: false,
      regEvent: null,
    };
  },
  methods: {
    async getEvents() {
      const res = await this.callApi(
        "get",
        `/get_events_by_date?page=${this.currentPage}&itemPerPage=${this.itemPerPage}`
      );
      if (res.status == 200) {
        this.events = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Események betöltése sikertelen!");
      }
      window.scrollTo(0, 0);
    },
    handlePageChange(value) {
      this.currentPage = value;
      this.getEvents();
    },
    showRegModal(event) {
      this.data.userId = this.getUser.id;
      this.regEvent = event;
      this.regModal = true;
    },
    closeRegModal() {
      this.registrating = false;
      this.data.headcount = "";
      this.regModal = false;
    },
    async register() {
      if (this.data.headcount.length == 0)
        return this.$toast.warning("Létszám megadása kötelező!");

      this.registrating = true;

      const res = await this.callApi("post", "create_registration", this.data);

      if (res.status == 201) {
        this.$toast.success("Sikeres registráció!");
      } else {
        this.$toast.error("A regisztráció nem sikerült!");
      }

      this.registrating = false;
    },
  },
  created() {
    this.getEvents();
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
};
</script>