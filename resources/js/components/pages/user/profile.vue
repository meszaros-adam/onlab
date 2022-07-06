<template>
  <div class="container bg-dark rounded ms-auto my-5 p-5 text-light">
    <h1>Profil szerkesztése</h1>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Név:</label>
      <input v-model="data.name" type="text" class="form-control" />
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email cím:</label>
      <input v-model="data.email" type="email" class="form-control" />
    </div>
    <div class="mb-3">
      <label class="form-label text-danger">Jelenlegi jelszó:</label>
      <input
        v-model="data.password"
        placeholder="Jelszó megadása kötelező!"
        type="password"
        class="form-control"
      />
    </div>
    <div class="d-flex justify-content-around">
      <button
        class="btn btn-primary"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#others"
      >
        Továbbiak
      </button>
      <button @click="saveProfile" class="btn btn-success">
        <span
          class="spinner-border spinner-border-sm"
          role="status"
          aria-hidden="true"
          v-show="saving"
        ></span
        >Mentés
      </button>
    </div>

    <!--Others Collapse -->
    <div class="collapse" id="others">
      <div class="card card-body w-50">
        <button class="btn btn-warning mb-3" @click="pwChangeModal = true">
          Jelszó csere
        </button>
        <button @click="showDeleteModal" class="btn btn-danger">
          Fiók törlése
        </button>
      </div>
    </div>
    <!--Others Collapse -->

    <!--Password change modal -->
    <b-modal
      v-model="pwChangeModal"
      title="Jelszó módosítása: "
      hide-header-close
      hide-footer
      no-close-on-esc
      no-close-on-backdrop
    >
      <div class="mb-3">
        <label class="form-label">Új jelszó: </label>
        <input class="form-control" type="password" v-model="newPassword" />
      </div>
      <div class="mb-3">
        <label class="form-label">Új jelszó megerősítés: </label>
        <input
          class="form-control"
          type="password"
          v-model="newPasswordConfirmation"
        />
      </div>
      <div class="d-flex justify-content-end">
        <button
          type="button"
          class="btn btn-danger mx-2"
          @click="pwChangeModal = false"
        >
          Bezárás
        </button>
        <button
          type="button"
          :disabled="pwChanging"
          class="btn btn-success mx-2"
          @click="pwChange"
        >
          <span
            class="spinner-border spinner-border-sm"
            role="status"
            aria-hidden="true"
            v-show="pwChanging"
          ></span>
          <span class="sr-only">Mentés</span>
        </button>
      </div>
    </b-modal>
    <!--Password change modal -->

    <deleteModal> </deleteModal>
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
      saving: false,

      //password change
      newPassword: "",
      newPasswordConfirmation: "",
      pwChangeModal: false,
      pwChanging: false,
    };
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
  created() {
    this.data.email = this.getUser.email;
    this.data.name = this.getUser.name;
  },
  methods: {
    async saveProfile() {
      if (this.data.name.trim() == "")
        return this.$toast.warning("Név megadása kötelező!");
      if (this.data.email.trim() == "")
        return this.$toast.warning("Email megadása kötelező!");
      if (this.data.password.trim() == "")
        return this.$toast.warning("Jelszó megadása kötelező!");

      this.saving = true;

      const res = await this.callApi(
        "post",
        "/app/edit_user_by_user",
        this.data
      );

      if (res.status == 200) {
        this.$toast.success("Profil sikeresen szerkesztve!");
      } else {
        this.$toast.error("Profil szerkesztése sikertelen!");
      }

      this.saving = false;
    },
    showDeleteModal() {
      const deleteModalObj = {
        showDeleteModal: true,
        deleteUrl: "/app/delete_user",
        data: { id: this.getUser.id },
        msg: "Biztosan törölni akarja a fiókját?",
        successMsg: "Fiók sikeresen törölve!",
      };
      this.$store.commit("setDeleteModalObj", deleteModalObj);
    },
    async pwChange() {
      if (this.newPassword.trim().length < 6)
        return this.$toast.warning(
          "Legalább 6 karakter hosszú új jelszó megadása kötelező"
        );
      if (this.newPasswordConfirmation.trim().length < 6)
        return this.$toast.warning("Új jelszó megerősítése kötelező!");
      if (this.data.password.trim() == "")
        return this.$toast.warning("Jelenlegi jelszó megadása kötelező!");
      if (this.newPassword != this.newPasswordConfirmation)
        return this.$toast.warning("A megerősítő jelszó nem egyezik!");

      this.pwChanging = true;

      const res = await this.callApi("post", "/app/change_password", {
        newPassword: this.newPassword,
        newPassword_confirmation: this.newPasswordConfirmation,
        currentPassword: this.data.password,
      });

      if ((res.status == 200)) {
        this.$toast.success("Jelszó sikeresen módosítva!");
      } else {
        this.$toast.error("Jelszó módosítás sikertelen!");
      }

      this.pwChanging = false;
    },
  },
};
</script>