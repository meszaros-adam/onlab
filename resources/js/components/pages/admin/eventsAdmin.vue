<template>
  <div>
    <div class="container-fluid bg-dark ms-auto my-5 p-5">
      <button
        type="button"
        class="btn btn-success mb-3"
        data-bs-toggle="modal"
        data-bs-target="#addModal"
      >
        Esemény létrehozása:
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
          <tr>
            <th>1</th>
            <td>2023.12.18 18:40</td>
            <td>Mark dsad asdasdas</td>
            <td>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit.
              Necessitatibus culpa quae est voluptatibus magnam debitis
              corrupti, unde sunt quidem at.
            </td>
            <td>30</td>
            <td>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit. Enim
              optio voluptatibus dolorum nemo laboriosam facilis voluptatem
              quisquam mollitia aut vero?
            </td>
            <td>
              <div class="d-flex justify-content-around">
                <i class="bi bi-pencil-fill edit-icon" title="Szerkesztés"></i>
                <i class="bi bi-trash3-fill delete-icon" title="Törlés"></i>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
      data-bs-keyboard="false"
      data-bs-backdrop="static"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
              Esemény létrehozása:
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
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
              <input
                class="form-control"
                type="text"
                v-model="data.googleMaps"
              />
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Bezárás
            </button>
            <button type="button" class="btn btn-success" @click="add" :disabled="adding">
               <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-show="adding"></span>
                <span class="sr-only">Mentés</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
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
      adding: false,
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

      console.log(this.data);

      const res = await this.callApi("post", "/create_event", this.data);

      if (res.status == 201) {
        this.$toast.success("Esemény sikeresen létrehozva!");
      } else {
        this.$toast.error("Esemény létrehozása sikertelen!");
      }
      this.adding = false;
    },
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
};
</script>