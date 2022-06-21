<template>
  <div v-if="event" class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <div class="row">
      <div class="col-md-6">
        <h4>{{ event.name }}</h4>
        <p>{{ event.description }}</p>
        <div :style="[event.is_actual ? {} : { color: 'red' }]">
          Időpont: {{ event.date }}
        </div>
        <div>Helyszín: {{ event.location }}</div>
        <div>Létszám: {{ event.headcount }}</div>
        <div>
          <strong :style="[event.free_seats == 0 ? { color: 'red' } : {}]"
            >Szabad helyek: {{ event.free_seats }}</strong
          >
        </div>
        <div class="my-3">
          <div v-if="checkIfRegistered()">
            <button class="button btn btn-success" disabled>
              Regisztrálva
            </button>
          </div>
          <div v-else>
            <button
              class="button btn btn-success"
              :disabled="registerButtonDisabler()"
              @click="getUser ? showRegModal() : $router.push('/login')"
            >
              Regisztrálás
            </button>
          </div>
        </div>
      </div>
      <div v-if="event.google_maps_iframe" class="col-md-6">
        <h4>Térkép</h4>
        <div v-html="event.google_maps_iframe"></div>
      </div>
    </div>
    <div class="my-3 d-flex">
      <div v-for="(tag, t) in event.tags" :key="t">
        <a @click="handleTagFilter(tag.name)"
          ><i class="tag"> #{{ tag.name }} </i>
        </a>
      </div>
    </div>

    <comment-system></comment-system>
    

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
          :max="event.free_seats"
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
import commentSystem from '../partials/commentSystem.vue'

export default {
  components:{
    commentSystem,
  },
  data() {
    return {
      data: {
        headcount: 1,
        eventId: null,
      },
      event: null,
      regModal: false,
      registrating: false,
    };
  },
  methods: {
    async getEvent() {
      const res = await this.callApi(
        "get",
        `/app/get_single_event?id=${this.$route.params.id}`
      );
      if (res.status == 200) {
        this.event = res.data;
        this.data.eventId = this.event.id;
      } else {
        this.$toast.error("Esemény betöltése sikertelen!");
      }
    },
    showRegModal() {
      this.data.eventId = this.event.id;
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
      if (this.data.headcount > this.event.free_seats)
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
    //returns true is the user is registered to the event
    checkIfRegistered() {
      if (this.getUser) {
        return this.getUser.registrations.some(
          (reg) => reg["event_id"] === this.event.id
        );
      } else {
        return false;
      }
    },
    registerButtonDisabler() {
      if (this.event.free_seats > 0 && this.event.is_actual) {
        return false;
      } else {
        return true;
      }
    },
    handleTagFilter(tagName) {
      this.$store.commit("setTagFilter", tagName);
      this.$router.push("/");
    },
  },
  created() {
    this.getEvent();
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
};
</script>