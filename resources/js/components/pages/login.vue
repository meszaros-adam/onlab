<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <h1>Bejelentkezés:</h1>
    <div class="mb-3">
      <label class="form-label">Email cím:</label>
      <input
        type="email"
        class="form-control"
        placeholder="name@example.com"
        v-model="data.email"
      />
    </div>
    <div class="mb-3">
      <label class="form-label">Jelszó: </label>
      <input class="form-control" type="password" v-model="data.password" />
    </div>
    <div class="d-flex justify-content-end">
      <div class="mb3">
        <label class="form-label">Maradjak bejelentkezve: </label>
        <input
          type="checkbox"
          class="form-check-input"
          aria-label="Checkbox for following text input"
          v-model="data.remember"
        />
      </div>
      <button
        type="button"
        :disabled="loading"
        class="btn btn-success ms-5"
        @click="login"
      >
        <span
          class="spinner-border spinner-border-sm"
          role="status"
          aria-hidden="true"
          v-show="loading"
        ></span>
        <span class="sr-only">Bejelentkezés</span>
      </button>
    </div>
    <div class="text-center">
      <div>Bejelentkezés egyéb fiókkal:</div>
      <div>
        <i class="bi bi-facebook social-login-button facebook-color"></i>
        <i class="bi bi-google social-login-button google-color"></i>
      </div>
    </div>
    <div class="text-center mt-4">
      <router-link to="/registration" class="btn btn-secondary"
        >Regisztráció email-lel</router-link
      >
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        email: "",
        password: "",
        remember: false,
      },
      loading: false,
    };
  },
  methods: {
    async login() {
      if (this.data.email.trim() == "")
        return this.$toast.warning("Email cím nincs megadva!");
      if (this.data.password.trim() == "")
        return this.$toast.warning("Jelszó  nincs megadva!");

      this.loading = true;

      const res = await this.callApi("post", "/login", this.data);
      if (res.status == 200) {
        window.location = "/";
      } else {
        this.$toast.error(res.data);
      }
      this.loading = false;
    },
  },
};
</script>