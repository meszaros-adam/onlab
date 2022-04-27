<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <h1>Regisztráció:</h1>
    <div class="mb-3">
      <label class="form-label">Teljes név: </label>
      <input type="text" class="form-control" placeholder="Gipsz Jakab" v-model="data.name" />
    </div>
    <div class="mb-3">
      <label class="form-label">Email cím:</label>
      <input type="email" class="form-control" placeholder="name@example.com" v-model="data.email"/>
    </div>
    <div class="mb-3">
      <label class="form-label">Jelszó: </label>
      <input class="form-control" type="password" v-model="data.password"/>
    </div>
    <div class="mb-3">
      <label class="form-label">Jelszó megerősítése: </label>
      <input class="form-control" type="password" v-model="data.password_confirmation"/>
    </div>
    <div class="text-end">
      <button type="button" class="btn btn-success" @click="register" >Regisztráció</button>
    </div>
  </div>
</template>

<script>
export default {
  data(){
    return{
      data:{
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
    }
  },
  methods:{
     async register(){
      if(this.data.name.trim() == '') return this.$toast.warning('Név nincs megadva!')
      if(this.data.name.trim().length < 4) return this.$toast.warning('A név legalább három betű!')
      if(this.data.email.trim()=='') return this.$toast.warning('Email cím nincs megadva!')
      if(this.data.password.trim()=='') return this.$toast.warning('Jelszó nincs megadva!')
      if(this.data.password_confirmation.trim()=='') return this.$toast.warning('Jelszó megerősítő nincs megadva!')
      if(this.data.password.trim().length<6 || this.data.password_confirmation.trim().length <6 ) return this.$toast.warning('A jelszó legalább 6 karakter legyen!')
      if(this.data.password != this.data.password_confirmation) return this.$toast.warning('A jelszavaknak egyezniük kell!')

      const res = await this.callApi('post', '/registration', this.data)

      if(res.status == 201){
        this.$toast.success('Sikeres regisztráció!')
        this.$router.push('/login')
      }
      else{
        this.$toast.error(res.data.message)
      }
    },
  }
};
</script>