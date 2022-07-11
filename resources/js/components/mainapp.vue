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
            <li class="nav-item mx-3">
              <div class="d-flex">
                <input
                @input="handleClearSearchBar"
                  v-model="search"
                  class="form-control"
                  type="search"
                  placeholder="Keresés"
                  v-on:keyup.enter="searchEvent"
                /><i
                  @click="searchEvent"
                  class="bi bi-search mx-1 nav-link"
                  data-bs-toggle="collapse"
                  data-bs-target="#search-bar"
                ></i>
              </div>
            </li>
            <li class="nav-item dropdown" v-if="getUser.is_admin">
              <a
                class="nav-link dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
              >
                <i class="bi bi-table mx-1"></i>Admin Panel</a
              >
              <div class="dropdown-menu dropdown-menu-end">
                <router-link class="dropdown-item" to="/admin/events"
                  >Események</router-link
                >
                <router-link class="dropdown-item" to="/admin/tags"
                  >Címkék</router-link
                >
                <router-link class="dropdown-item" to="/admin/users"
                  >Felhasználók</router-link
                >
                <router-link class="dropdown-item" to="/admin/registrations"
                  >Regisztrációk</router-link
                >
                <router-link class="dropdown-item" to="/admin/comments"
                  >Kommentek</router-link
                >
              </div>
            </li>
            <li class="nav-item mx-1" v-if="getUser == false">
              <router-link to="/registration" class="nav-link"
                >Regisztráció</router-link
              >
            </li>
            <li class="nav-item" v-if="getUser == false">
              <router-link to="/login" class="nav-link"
                >Bejelentkezés
              </router-link>
            </li>
            <li class="nav-item dropdown" v-else>
              <a
                class="nav-link dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                ><i class="bi bi-person-fill mx-1"></i>{{ getUser.name }}</a
              >
              <div class="dropdown-menu dropdown-menu-end">
                <router-link class="dropdown-item" to="/user/registrations"
                  >Regisztrációk</router-link
                >
                <router-link class="dropdown-item" to="/user/comments"
                  >Kommentek</router-link
                >
                <router-link class="dropdown-item" to="/user/profile"
                  >Profil</router-link
                >
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
      Minden Jog Fenntartva!
    </footer>
    <!-- FOOTER -->
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  props: ["user"],
  data() {
    return {
      search: "",
    };
  },
  created() {
    this.$store.commit("setUser", this.user);
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
  methods: {
    handleClearSearchBar() {
      if (this.search == "") {
        this.searchEvent();
      }
    },
    searchEvent() {
      if (this.$router.history.current.path != "/") {
        this.$router.push("/");
      }

      this.$store.commit("setSearchEvent", this.search);
    },
  },
};
</script>