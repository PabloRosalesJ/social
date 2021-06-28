<template>
  <div>
    <form @submit.prevent="submit()" v-if="isAuthenticated">
      <div class="card-body">
        <textarea
          v-model="body"
          class="form-control border-0"
          name="body"
          :placeholder="`¿Qué estas pensando ${currentUser.name}`"
        ></textarea>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary" id="create-status">
          <i class="fa fa-paper-plane"></i>
          Publicar
        </button>
      </div>
    </form>

    <div class="card-body" v-else>
      <h4 class="text-center">Debes hacer <a href="/login">login</a>.</h4>
    </div>
  </div>
</template>
<script>
export default {
  name: "",
  data() {
    return {
      body: "",
    };
  },
  methods: {
    submit() {
      axios
        .post("/statuses", {
          body: this.body,
        })
        .then((result) => {
          EventBuss.$emit("status-created", result.data.data);
          this.body = "";
        })
        .catch((err) => {});
    },
  },
};
</script>
