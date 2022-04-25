<template>
  <div class="d-flex flex-column min-vh-100">
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
              <a class="nav-link" href="#">Események</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Felhasználók</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="#">Címkék</a>
            </li>
            <li class="nav-item" v-if="$store.state.user">
              <a class="nav-link" href="#">Regisztráció</a>
            </li>
            <li class="nav-item" v-if="$store.state.user">
              <a class="nav-link" href="#">Bejelentkezés</a>
            </li>
            <li class="nav-item" v-else>
              <a class="nav-link" href="#">Kijelentkezés</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- NAV -->

    <!-- FOOTER -->
    <footer class="p-3 bg-dark text-light text-center mt-auto">
      Minden Jog Fenntartva
    </footer>
    <!-- FOOTER -->
  </div>
</template>

<script>
export default {
  props:['user'],
  data(){

  },
  created(){
    this.$store.commit('setUser', this.user)
  }
}
</script>