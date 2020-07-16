<template>
  <div class="container">
    <h5>Update post</h5>

    <form @submit.prevent="update">
      <div class="form-group mt-5">
        <textarea v-model="post.body" class="form-control" rows="5"></textarea>
        <template v-if="errors.body">
          <small class="form-text text-danger" v-for="error in errors.body">
            {{ error }}
          </small>
        </template>
      </div>
      <button class="btn btn-success">Update</button>
    </form>
    <p class="mt-5 btn">
      <nuxt-link to="/topics">Back to topics</nuxt-link>
    </p>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        post: {
          body: ''
        }
      }
    },
    async asyncData({$axios, params}) {
      const {data} = await $axios.$get(`/api/topics/${params.id}/posts/${params.body}`);
      return {post: data};
    },
    methods: {
      async update() {
        try {
          await this.$axios.$patch(`/api/topics/${this.$route.params.id}/posts/${this.$route.params.body}`, {
            body: this.post.body
          });
          this.$router.push('/topics');
        } catch (err) {
          console.log(err);
        }
      }
    }
  }
</script>
