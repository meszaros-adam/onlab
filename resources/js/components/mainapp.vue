<template>
  <div class="d-flex flex-column bg-black min-vh-100">
    <!-- NAV -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Eseménynaptár</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item active">
              <router-link to="/events-admin" class="nav-link">Események</router-link>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Felhasználók</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Címkék</a>
            </li>
            <li class="nav-item" v-if="getUser == false">
              <router-link to="/registration" class="nav-link">Regisztráció</router-link>
            </li>
            <li class="nav-item" v-if="getUser == false">
              <router-link to="/login" class="nav-link">Bejelentkezés</router-link>
            </li>
            <li class="nav-item" v-else>
              <a class="nav-link" href="/logout">Kijelentkezés</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- NAV -->

    <!-- ROUTER -->
    <router-view> </router-view>
    <!-- ROUTER -->

    <!-- FOOTER -->
    <footer class="p-3 bg-dark text-light text-center mt-auto">
      Minden Jog Fenntartva
    </footer>
    <!-- FOOTER -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: ["user"],
  data() {
    return {};
  },
  created() {
    this.$store.commit("setUser", this.user);
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
};
</script>