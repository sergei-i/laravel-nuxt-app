<template>
  <div class="container">
    <div class="bg-light mt-5 mb-5" style="padding: 20px">
      <h5>{{ topic.title }}</h5>
      <hr>
      <p class="text-muted">{{ topic.created_at }} by {{ topic.user.name }}</p>

      <div v-for="(content, index) in topic.posts" :key="index" class="ml-4 content">
        {{ content.body }}
        <p class="text-muted">{{ content.created_at }} by {{ content.user.name }}</p>
      </div>
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
        topic: ''
      }
    }
  }
</script>
