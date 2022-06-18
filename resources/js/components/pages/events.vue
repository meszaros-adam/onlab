<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <div class="d-flex justify-content-end">
      <select
        class="form-select mb-4"
        style="width: auto"
        v-model="eventActuality"
        aria-label="Default select example"
        @change="getEvents"
      >
        <option value="actual">Aktuálisak</option>
        <option value="earlier">Korábbiak</option>
      </select>
    </div>
    <div class="d-flex" v-if="tagFilter">
      <h1>#{{ tagFilter }}</h1>
      <a title="Címke szűrő törlése" @click="handleTagFilter(null)"
        ><i class="bi bi-x-circle"></i
      ></a>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
      <div class="col mb-4" v-for="(event, e) in events" :key="e">
        <div class="card text-dark">
          <router-link  tag="div" :to="{ name: 'event', params: { id: event.id } }">
            <div class="card-body">
              <h5 class="card-title">{{ event.name }}</h5>
              <p class="card-text">{{ event.description }}</p>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Időpont: {{ event.date }}</li>
              <li class="list-group-item">Helyszín: {{ event.location }}</li>
              <li class="list-group-item">Létszám: {{ event.headcount }}</li>
              <li class="list-group-item">
                <strong :style="[event.free_seats == 0 ? { color: 'red' } : {}]"
                  >Szabad helyek: {{ event.free_seats }}</strong
                >
              </li>
            </ul>
          </router-link>
          <div class="list-group-item d-flex" v-if="event.tags.length > 0">
            <div class="mx-1" v-for="(tag, t) in event.tags" :key="t">
              <a @click="handleTagFilter(tag.name)"
                ><i
                  class="tag"
                  :style="[tagFilter == tag.name ? { color: 'red' } : {}]"
                  >#{{ tag.name }}</i
                ></a
              >
            </div>
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
import { mapGetters } from "vuex";

export default {
  data() {
    return {
      data: {
        headcount: 1,
        eventId: null,
      },
      events: [],
      orderBy: "date",
      eventActuality: "actual",
      tagFilter: null,

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
        this.tagFilter
          ? `/app/get_${this.eventActuality}_events?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}&tagFilter=${this.tagFilter}`
          : `/app/get_${this.eventActuality}_events?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}`
      );
      if (res.status == 200) {
        this.events = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Események betöltése sikertelen!");
      }
      window.scrollTo(0, 0);
    },
    handlePageChange(value) {
      this.currentPage = value;
      this.getEvents();
    },
    handleTagFilter(tagName) {
      this.tagFilter = tagName;
      this.getEvents();
    },
  },
  created() {
    this.getEvents();
  },
  computed: {
    ...mapGetters(["getUser"]),
  },
};
</script>