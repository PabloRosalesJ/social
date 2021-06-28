<template>
  <div>
    <status-list-item
      v-for="status in statuses"
      :key="status.id"
      :status="status"
    >
    </status-list-item>
  </div>
</template>
<script>
import StatusListItem from "./StatusListItem.vue";

export default {
  components: { StatusListItem },
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
};
</script>
