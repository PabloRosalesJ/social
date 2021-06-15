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
            src="https://dummyimage.com/40x40/5e6e9e/ffffff&text=P%20R"
          />
          <div>
            <h5 class="mb-1" v-text="status.user_name"></h5>
            <div class="small text-muted" v-text="status.ago"></div>
          </div>
        </div>
        <p v-text="status.body"></p>
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

    console.log(this.user);
  },
};
</script>
