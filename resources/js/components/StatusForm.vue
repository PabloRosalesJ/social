<template>
  <div>
    <form @submit.prevent="submit()" v-if="isAuthenticated">
      <div class="card-body">
        <textarea
          v-model="body"
          class="form-control border-0"
          name="body"
          :placeholder="`¿Qué estas pensando ${user.name}`"
        ></textarea>
      </div>
      <div class="card-footer">
        <button class="btn btn-primary" id="create-status">Guardar</button>
      </div>
    </form>

    <div class="card-body" v-else>
      <p class="text-center">Debes hacer <a href="/login">login</a>.</p>
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
        .catch((err) => {
          console.log(err.message);
        });
    },
  },
};
</script>
