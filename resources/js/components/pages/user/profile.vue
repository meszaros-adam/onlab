<template>
  <div class="container bg-dark ms-auto my-5 p-5 text-light">
    <h1>Profil szerkesztése</h1>
    <form>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Név:</label>
        <input
          v-model="data.name"
          type="text"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email cím:</label>
        <input
          v-model="data.email"
          type="email"
          class="form-control"
          id="exampleInputEmail1"
          aria-describedby="emailHelp"
        />
      </div>
      <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Jelszó:</label>
        <input
          placeholder="Jelszó megadása kötelező!"
          type="password"
          class="form-control"
          id="exampleInputPassword1"
        />
      </div>
      <div class="d-flex justify-content-around">
        <button type="submit" class="btn btn-danger">Fiók törlése</button>
        <button type="submit" class="btn btn-success">Mentés</button>
      </div>
      
    </form>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import deleteModal from "../../partials/deleteModal.vue";
export default {
  components: { deleteModal },
  data() {
    return {
      data: {
        email: "",
        name: "",
        password: "",
      },
    };
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
  created() {
    this.data.email = this.getUser.email;
    this.data.name = this.getUser.name;
  },
};
</script>