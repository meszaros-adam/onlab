<template>
  <div class="container bg-dark ms-auto my-5 text-light p-5 rounded">
    <div class="d-flex justify-content-end">
      <select
        class="form-select mb-4"
        style="width: auto"
        v-show="actualityChanger"
        v-model="eventActuality"
        aria-label="Default select example"
        @change="handleActualityChange()"
      >
        <option value="actual">Aktuálisak</option>
        <option value="earlier">Korábbiak</option>
      </select>
    </div>
    <div class="d-flex" v-if="getTagFilter">
      <h1>#{{ getTagFilter }}</h1>
      <a title="Címke szűrő törlése" @click="handleTagFilter(null)"
        ><i class="bi bi-x-circle"></i
      ></a>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
      <div class="col mb-4" v-for="(event, e) in events" :key="e">
        <div class="card event text-dark">
          <router-link
            tag="div"
            :to="{ name: 'event', params: { id: event.id } }"
          >
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
                  :style="[getTagFilter == tag.name ? { color: 'red' } : {}]"
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
      actualityChanger: true,
      eventActuality: "actual",

      //pagination
      itemPerPage: 10,
      currentPage: 1,
      total: 0,

      searching: false,
    };
  },
  methods: {
    async getEvents() {
      const res = await this.callApi(
        "get",
        this.getTagFilter
          ? `/app/get_events_paginated?actuality=${this.eventActuality}&?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}&tagFilter=${this.getTagFilter}`
          : `/app/get_events_paginated?actuality=${this.eventActuality}&?page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}`
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

      if(this.searching){
        this.searchEvents
      }else{
        this.getEvents();
      }
      
    },
    handleTagFilter(tagName) {
      this.$store.commit("setTagFilter", tagName);
      this.getEvents();
    },
    handleActualityChange() {
      this.resetPagination();
      this.getEvents();
    },
    resetPagination() {
      //reset pagination variables
      this.itemPerPage = 10;
      this.currentPage = 1;
      this.total = 0;
    },
    async searchEvents(q) {
      const res = await this.callApi(
        "get",
        `/app/search_event?search=${q}&page=${this.currentPage}&itemPerPage=${this.itemPerPage}&orderBy=${this.orderBy}`
      );

      if (res.status == 200) {
        this.events = res.data.data;
        this.currentPage = res.data.current_page;
        this.total = res.data.total;
      } else {
        this.$toast.error("Keresés sikertelen!");
      }
    },
  },
  created() {
    this.getEvents();
  },
  computed: {
    ...mapGetters(["getUser", "getTagFilter", "getSearchEvent"]),
  },
  watch: {
    getSearchEvent(q) {
      //delete tag filter
      this.$store.commit("setTagFilter", null);

      this.resetPagination();

      if (q == "") {
        this.searching = false;
        this.actualityChanger = true;
        this.getEvents();
      } else {
        this.searching = true;
        this.actualityChanger = false;
        this.searchEvents(q);
      }
    },
  },
};
</script>