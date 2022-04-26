<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <h1>Bejlentkezés:</h1>
    <div class="mb-3">
      <label class="form-label">Email cím:</label>
      <input type="email" class="form-control" placeholder="name@example.com" />
    </div>
    <div class="mb-3">
      <label class="form-label">Jelszó: </label>
      <input class="form-control" type="password" />
    </div>
    <div class="d-flex justify-content-end">
      <div class="mb3">
        <label class="form-label">Maradjak bejelentkezve: </label>
        <input
          type="checkbox"
          class="form-check-input"
          aria-label="Checkbox for following text input"
        />
      </div>
      <button type="button" @click="toastTest" class="btn btn-success ms-5">Bejelentkezés</button>
    </div>
    <div class="text-center">
      <div>Bejeletkezés egyéb fiókkal:</div>
      <div>
        <a href="" class="bi bi-facebook social-login-button facebook-color"></a>
        <a href="" class="bi bi-google social-login-button google-color"></a>
      </div>
    </div>
  </div>
</template>

<script>
export default {

  methods:{
    toastTest(){
      this.$toast.error('Hibás adatokat adott meg')
    },
  }
};
</script>