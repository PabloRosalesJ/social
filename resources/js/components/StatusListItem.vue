<template>
  <div class="card border-0 mb-3 shadow-sm">
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
      class="card-footer p-2 d-flex justify-content-between align-items-center"
      @click="redirecIfGuest"
    >
      <like-button
        dusk="like-btn"
        :model="status"
        :url="`/statuses/${status.id}/likes`"
      >
      </like-button>
      <div class="text-secondary mr-2">
        <i class="far fa-thumbs-up"></i>
        <span dusk="likes-count" v-text="status.likes_count"></span>
      </div>
    </div>

    <div class="card-footer">

      <div v-for="comment in comments" class="mb-3">

        <div class="d-flex">
            <img
                class="rounded shadow-sm mr-2"
                width="35px"
                height="35px"
                :src="`https://dummyimage.com/500x500/5e6e9e/ffffff&text=${comment.user_name}`"
            />

            <div class="flex-grow-1">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-2 text-secondary">
                        <a href="#">
                        <strong> {{ comment.user_name }} </strong>
                        </a>
                        {{ comment.body }}
                    </div>
                </div>
                <small class="float-right badge badge-pill badge-primary py-1 px-2 mt-1" dusk="comment-likes-count">
                    <i class="fa fa-thumbs-up"></i>
                    {{ comment.likes_count }}
                </small>
                <like-button
                    dusk="comment-like-btn"
                    :model="comment"
                    :url="`/comments/${comment.id}/likes`"
                    class="comments-like-btn"
                >
                </like-button>
            </div>

        </div>


      </div>

      <form @submit.prevent="saveComment" v-if="isAuthenticated">
        <div class="d-flex align-items-center">
          <img
            class="rounded shadow-sm float-left mr-2"
            width="35px"
            height="35px"
            :src="`https://dummyimage.com/500x500/5e6e9e/ffffff&text=${currentUser.name}`"
            :alt="currentUser.name"
          />
          <textarea
            v-model="newComment"
            class="form-control border-0 shadow-sm"
            name="comment"
            rows="1"
            placeholder="Escribe un commentario ..."
          >
          </textarea>
          <button dusk="comment-btn" class="ml-2 btn btn-primary">
            Comentar
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
import LikeButton from "./LikeButton.vue";
export default {
  name: "StatusListItem",
  components: { LikeButton },
  props: {
    status: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      comments: this.status.comments,
      newComment: "",
    };
  },
  methods: {
    saveComment() {
      axios
        .post(`status/${this.status.id}/comment`, { body: this.newComment })
        .then((result) => {
          this.newComment = "";
          this.comments.push(result.data.data);
        })
        .catch((err) => {});
    },
  },
};
</script>
