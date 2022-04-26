<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <h1>Regisztráció:</h1>
    <div class="mb-3">
      <label class="form-label">Teljes név: </label>
      <input type="text" class="form-control" placeholder="Gipsz Jakab" />
    </div>
    <div class="mb-3">
      <label class="form-label">Email cím:</label>
      <input type="email" class="form-control" placeholder="name@example.com" />
    </div>
    <div class="mb-3">
      <label class="form-label">Jelszó: </label>
      <input class="form-control" type="password" />
    </div>
    <div class="mb-3">
      <label class="form-label">Jelszó megerősítése: </label>
      <input class="form-control" type="password" />
    </div>
    <div class="text-end">
      <button type="button" class="btn btn-success">Regisztráció</button>
    </div>
  </div>
</template>

<script>
export default {};
</script>