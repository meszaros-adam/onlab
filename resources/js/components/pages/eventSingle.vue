<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <div class="row">
      <div class="col-md-6">
        <h4>{{ event.name }}</h4>
        <p>{{ event.description }}</p>
        <div>Időpont: {{ event.date }}</div>
        <div>Helyszín: {{ event.location }}</div>
        <div>Létszám: {{ event.headcount }}</div>
        <div>
          <strong :style="[event.free_seats == 0 ? { color: 'red' } : {}]"
            >Szabad helyek: {{ event.free_seats }}</strong
          >
        </div>
        <button type="button" class="btn btn-success my-3">Regisztrálás</button>
        <div class="d-flex"></div>
      </div>
      <div v-if="event.google_maps_iframe" class="col-md-6">
        <h4>Térkép</h4>
        <div v-html="event.google_maps_iframe"></div>
      </div>
    </div>
    <div class="my-3" v-for="(tag, t) in event.tags" :key="t">
      <a
        ><i class="tag"> #{{ tag.name }} </i>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      event: null,
    };
  },
  methods: {
    async getEvent() {
      const res = await this.callApi(
        "get",
        `/app/get_single_event?id=${this.$route.params.id}`
      );
      if (res.status == 200) {
        this.event = res.data;
      } else {
        this.$toast.error("Esemény betöltése siekrtelen!");
      }
    },
  },
  created() {
    this.getEvent();
  },
};
</script>