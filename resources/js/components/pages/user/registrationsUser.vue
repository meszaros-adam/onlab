<template>
  <registrations getUrl="/app/get_user_registrations"></registrations>
</template>

<script>
import registrations from "../../partials/registrationsTable.vue";
export default {
  components: { registrations },
};
</script>