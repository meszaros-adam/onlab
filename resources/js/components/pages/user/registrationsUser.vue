<template>
  <registrations getUrl="app/get_user_registrations"></registrations>
</template>

<script>
import registrations from "../../partials/registrations.vue";
export default {
  components: { registrations },
};
</script>