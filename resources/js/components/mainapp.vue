<template>
  <div class="d-flex flex-column bg-black min-vh-100">
    <!-- NAV -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top bg-success">
      <div class="container">
        <router-link to="/" class="navbar-brand">Eseménynaptár</router-link>
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
              <router-link to="/events-admin" class="nav-link"
                >Események</router-link
              >
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Felhasználók</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Címkék</a>
            </li>
            <li class="nav-item" v-if="getUser == false">
              <router-link to="/registration" class="nav-link"
                >Regisztráció</router-link
              >
            </li>
            <li class="nav-item" v-if="getUser == false">
              <router-link to="/login" class="nav-link"
                >Bejelentkezés </router-link
              >
            </li>
            <li class="nav-item dropdown" v-else>
              <a
                class="nav-link dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                >{{ getUser.name }} <span v-if="getUser.admin === 1">(Admin)</span></a
              >
              <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="">Példa</a>
                <a class="dropdown-item" href="">Példa</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="/logout">Kijelentkezés</a>
              </div>
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
    <footer class="p-3 bg-success text-light text-center mt-auto">
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