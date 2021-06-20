<template>
  <div>
    <div
      class="card border-0 mb-3 shadow-sm"
      v-for="status in statuses"
      :key="status.id"
    >
      <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center mb-3">
          <img
            class="rounded mr-3"
            width="40px"
            height="40px"
            :src="`https://dummyimage.com/500x500/5e6e9e/ffffff&text=${status.user_name[0]}`"
          />
          <div>
            <h5 class="mb-1" v-text="status.user_name"></h5>
            <div class="small text-muted" v-text="status.ago"></div>
          </div>
        </div>
        <p v-text="status.body"></p>
      </div>
      <div
        class="
          card-footer
          p-2
          d-flex
          justify-content-between
          align-items-center
        "
        @click="redirecIfGuest"
      >
        <button
          v-if="status.is_liked"
          @click="unlike(status)"
          class="btn btn-link btn-small"
          dusk="unlike-btn"
        >
          <i class="fa fa-thumbs-up text-primary"></i>
          <strong>TE GUSTA</strong>
        </button>
        <button
          v-else
          @click="like(status)"
          class="btn btn-link btn-small"
          dusk="like-btn"
        >
          <i class="far fa-thumbs-up text-primary"></i>
          ME GUSTA
        </button>
        <div class="text-secondary mr-2">
          <i class="far fa-thumbs-up"></i>
          <span dusk="likes_count" v-text="status.likes_count"></span>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// import auth from "../mixins/auth";

export default {
  data() {
    return {
      statuses: [],
    };
  },
  mounted() {
    axios
      .get("/statuses")
      .then((result) => {
        this.statuses = result.data.data;
      })
      .catch((err) => {
        console.log(err);
      });

    EventBuss.$on("status-created", (status) => {
      this.statuses.unshift(status);
    });
  },
  methods: {
    like(status) {
      axios
        .post(`/statuses/${status.id}/likes`)
        .then((result) => {
          status.is_liked = true;
          status.likes_count++;
        })
        .catch((err) => {});
    },
    unlike(status) {
      axios
        .delete(`/statuses/${status.id}/likes`)
        .then((result) => {
          status.is_liked = false;
          status.likes_count--;
        })
        .catch((err) => {});
    },
  },
};
</script>
