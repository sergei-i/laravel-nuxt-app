<template>
  <div class="container">
    <h2>Topics</h2>
    <div v-for="(topic, index) in topics" :key="index" class="bg-light mt-5 mb-5" style="padding: 20px">
      <h5>
        <nuxt-link :to="{name: 'topics-id', params: {id: topic.id}}">
          {{ topic.title }}
        </nuxt-link>
      </h5>
      <p class="text-muted">{{ topic.created_at }} by {{ topic.user.name }}</p>

      <div v-for="(content, index) in topic.posts" :key="index" class="ml-4 content">
        {{ content.body }}
        <p class="text-muted">{{ content.created_at }} by {{ content.user.name }}</p>
      </div>
    </div>

    <nav>
      <ul class="pagination justify-content-center">
        <li v-for="(key, value) in links" class="page-item">
          <a @click="loadMore(key)" href="#" class="page-link">{{ value }}</a>
        </li>
      </ul>
    </nav>

  </div>
</template>

<script>
  export default {
    async asyncData({$axios}) {
      let {data, links} = await $axios.$get('api/topics');
      return {
        topics: data,
        links
      }
    },
    data() {
      return {
        topics: [],
        links: []
      }
    },
    methods: {
      async loadMore(key) {
        try {
          let {data} = await this.$axios.$get(key);
          return this.topics = {...this.topics, ...data};
        } catch (err) {
          console.log(err)
        }
      }
    }
  }
</script>

<style scoped>
  .content {
    border-left: 10px solid white;
    padding: 0 10px 0 10px;
  }
</style>
