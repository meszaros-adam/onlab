<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
      <div class="col mb-4" v-for="(event, e) in events" :key="e">
        <div class="card text-dark">
          <div class="card-body">
            <h5 class="card-title">{{ event.name }}</h5>
            <p class="card-text">Leírás: {{ event.description }}</p>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">Időpont: {{ event.date }}</li>
            <li class="list-group-item">Helyszín: {{ event.location }}</li>
            <li class="list-group-item">Létszám: {{ event.headcount }}</li>
            <li class="list-group-item">Szabad helyek: {{ event.free_seats }}</li>
          </ul>
          <div class="card-body text-end">
            <div class="button btn btn-success">Regisztrálás</div>
          </div>
        </div>
      </div>
    </div>
    <!-- Pagination -->
    <b-pagination
      v-model="currentPage"
      :total-rows="total"
      :per-page="itemPerPage"
      align="center"
      @change="handlePageChange"
    ></b-pagination>
    <!-- Pagination -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      events: [],

      //pagination
      itemPerPage: 10,
      currentPage: 1,
      total: 0,
    };
  },
  methods: {
    async getEvents() {
      const res = await this.callApi(
        "get",
        `/get_events_by_date?page=${this.currentPage}&itemPerPage=${this.itemPerPage}`
      );
      if (res.status == 200) {
        this.events = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Események betöltése sikertelen!");
      }
      window.scrollTo(0,0);
    },
    handlePageChange(value) {
      this.currentPage = value;
      this.getEvents();
    },
  },
  created() {
    this.getEvents();
  },
};
</script>