<template>
  <div class="container">
    <div class="bg-light mt-5 mb-5" style="padding: 20px">
      <h5>{{ topic.title }}</h5>
      <hr>
      <p class="text-muted">{{ topic.created_at }} by {{ topic.user.name }}</p>

      <div v-for="(content, index) in topic.posts" :key="index" class="ml-4 content">
        <p>{{ content.body }}</p>

        <div v-if="authenticated">
          <button
            v-if="user.id === content.user.id"
            @click="deletePost(content.id)"
            class="btn btn-outline-danger fa fa-trash pull-right"
          ></button>

          <div v-if="user.id === content.user.id">
            <nuxt-link :to="{name: 'topics-posts-edit', params: {id: $route.params.id, body: content.id}}">
              <button class="btn btn-outline-success fa fa-edit pull-right"></button>
            </nuxt-link>
          </div>
        </div>

        <p class="text-muted">{{ content.created_at }} by {{ content.user.name }}</p>
      </div>
    </div>

    <div class="mt-5 ml-5 mb-5" v-if="authenticated">
      <form @submit.prevent="create">
        <p><strong>Add a new post</strong></p>
        <textarea v-model="body" class="form-control" rows="5"></textarea>
        <template v-if="errors.body">
          <small class="form-text text-danger" v-for="error in errors.body">
            {{ error }}
          </small>
        </template>
        <button class="btn btn-primary mt-3">Add a new post</button>
      </form>
    </div>
  </div>
</template>

<script>
  export default {
    async asyncData({$axios, params}) {
      const {data} = await $axios.$get(`/api/topics/${params.id}`);
      return {topic: data};
    },
    data() {
      return {
        topic: '',
        body: ''
      }
    },
    methods: {
      async create() {
        try {
          await this.$axios.$post(`/api/topics/${this.$route.params.id}/posts`, {
            body: this.body
          });
          this.$router.push('/topics');
        } catch (err) {
          console.log(err);
        }
      },
      async deletePost(id) {
        try {
          await this.$axios.$delete(`/api/topics/${this.$route.params.id}/posts/${id}`);
          this.$router.push('/');
        } catch (err) {
          console.log(err);
        }
      }
    }
  }
</script>
