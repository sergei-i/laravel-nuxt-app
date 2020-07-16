<template>
  <div class="container">
    <h5>Update topic title</h5>

    <form @submit.prevent="update">
      <div class="form-group mt-5">
        <input type="text" class="form-control" v-model="topic.title">
        <template v-if="errors.title">
          <small class="form-text text-danger" v-for="error in errors.title">
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
        topic: {
          title: ''
        }
      }
    },
    async asyncData({$axios, params}) {
      const {data} = await $axios.$get(`/api/topics/${params.id}`);
      return {topic: data};
    },
    methods: {
      async update() {
        try {
          await this.$axios.$patch(`/api/topics/${this.$route.params.id}`, {
            title: this.topic.title
          });
          this.$router.push('/topics');
        } catch (err) {
          console.log(err);
        }
      }
    }
  }
</script>
