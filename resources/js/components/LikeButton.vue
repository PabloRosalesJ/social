<template>
  <button @click="toggle()" :class="getBtnClasses">
    <i :class="getIconClasses"></i>
    {{ getLikeText }}
  </button>
</template>
<script>
export default {
  name: "LikeButton",
  props: {
    model: {
      type: Object,
      required: true,
    },
    url: {
      type: String,
      required: true,
    },
  },
  methods: {
    toggle() {
      let method = this.model.is_liked ? "delete" : "post";
      axios[method](this.url)
        .then((result) => {
          this.model.is_liked = !this.model.is_liked;
          if (method === "post") {
            this.model.likes_count++;
          } else {
            this.model.likes_count--;
          }
        })
        .catch((err) => {});
    },
    // like() {
    //   axios
    //     .post(this.url)
    //     .then((result) => {
    //       this.model.is_liked = true;
    //       this.model.likes_count++;
    //     })
    //     .catch((err) => {});
    // },
    // unlike() {
    //   axios
    //     .delete(this.url)
    //     .then((result) => {
    //       this.model.is_liked = false;
    //       this.model.likes_count--;
    //     })
    //     .catch((err) => {});
    // },
  },
  computed: {
    getLikeText() {
      return this.model.is_liked ? "ME GUSTA" : "TE GUSTA";
    },
    getBtnClasses() {
      return [
        this.model.is_liked ? "font-weight-bold" : "",
        "btn",
        "btn-link",
        "btn-small",
      ];
    },
    getIconClasses() {
      return [
        this.model.is_liked ? "fa" : "far",
        "fa-thumbs-up",
        "text-primary",
        "mr-1",
      ];
    },
  },
};
</script>

<style lang="scss" scoped>
    .comments-like-btn{
        font-size: 0.8em;
        padding-left: 0px;
        i { display: none; }
    }
</style>
