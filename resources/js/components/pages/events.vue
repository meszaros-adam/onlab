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
              <strong
                :style="[
                  event.free_seats == 0 ? { color: 'red' } : { color: 'black' },
                ]"
                >Szabad helyek: {{ event.free_seats }}</strong
              >
            </li>
          </ul>
          <div class="card-body text-end" v-if="checkIfRegistered(event.id)">
            <button class="button btn btn-success" disabled>
              Regisztrálva
            </button>
          </div>
          <div class="card-body text-end" v-else>
            <button
              class="button btn btn-success"
              :disabled="event.free_seats == 0"
              @click="getUser ? showRegModal(event) : $router.push('/login')"
            >
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
        headcount: 1,
        eventId: null,
      },
      events: [],
      orderBy: 'date',

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
        `/app/get_events?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}`
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
      this.regEvent = event;
      this.data.eventId = this.regEvent.id;
      this.regModal = true;
    },
    closeRegModal() {
      this.registrating = false;
      this.data.headcount = 1;
      this.regModal = false;
    },
    async register() {
      if (this.data.headcount.length == 0)
        return this.$toast.warning("Létszám megadása kötelező!");
      if (this.data.headcount > this.regEvent.free_seats)
        return this.$toast.warning("Nincs ennyi szabad hely!");
      if (this.data.headcount > 5)
        return this.$toast.warning("Legfejebb öt fővel regisztrálhat!");

      this.registrating = true;

      const res = await this.callApi(
        "post",
        "/app/create_registration",
        this.data
      );

      if (res.status == 201) {
        this.$store.commit("registrating", res.data);
        this.$toast.success("Sikeres registráció!");
      } else {
        this.$toast.error(res.data.message);
      }

      this.registrating = false;
      this.regModal = false;
    },
    checkIfRegistered(eventId) {
      if (this.getUser) {
        return this.getUser.registrations.some(
          (reg) => reg["event_id"] === eventId
        );
      } else {
        true;
      }
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