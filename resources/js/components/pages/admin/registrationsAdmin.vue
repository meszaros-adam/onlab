<template>
    <registrations getUrl="/app/get_registrations"></registrations>
</template>

<script>
import registrations from '../../partials/registrationsTable.vue'
export default {
  components: {registrations}
  
}
</script>