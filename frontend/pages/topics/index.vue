<template>
  <div class="container">
    <h2>Topics</h2>
    <div v-for="(topic, index) in topics" :key="index" class="bg-light mt-5 mb-5" style="padding: 20px">
      <h5>
        <nuxt-link :to="{name: 'topics-id', params: {id: topic.id}}">
          {{ topic.title }}
        </nuxt-link>
      </h5>

      <div v-if="authenticated">
        <button
          v-if="user.id === topic.user.id"
          @click="deleteTopic(topic.id)"
          class="btn btn-outline-danger fa fa-trash pull-right"
        ></button>

        <div v-if="user.id === topic.user.id">
          <nuxt-link :to="{name: 'topics-edit', params: {id: topic.id}}">
            <button class="btn btn-outline-success fa fa-edit pull-right"></button>
          </nuxt-link>
        </div>
      </div>

      <p class="text-muted">{{ topic.created_at }} by {{ topic.user.name }}</p>

      <div v-for="(content, index) in topic.posts" :key="index" class="ml-4 content">
        {{ content.body }}
        <p class="text-muted">{{ content.created_at }} by {{ content.user.name }}</p>
        <div
          @click="likePost(topic.id, content)"
          class="btn btn-outline-primary fa fa-thumbs-up ml-5 mb-2"
        >
          <span class="badge">{{ content.like_count }}</span>
        </div>
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
          console.log(err);
        }
      },
      async deleteTopic(id) {
        try {
          await this.$axios.$delete(`/api/topics/${id}`);
          this.$router.push('/');
        } catch (err) {
          console.log(err);
        }
      },
      async likePost(topicId, content) {
        const userFromVuex = this.$store.getters['user'];
        if (userFromVuex) {
          if (userFromVuex.id === content.user.id) {
            alert('You can\'t like your own post');
          }
          if (content.users) {
            if (content.users.some(user => user.id === userFromVuex.id)) {
              alert('You have already liked this post');
            } else {
              try {
                await this.$axios.$post(`api/topics/${topicId}/posts/${content.id}/likes`);
                let {data, links} = await this.$axios.$get('api/topics');
                this.topics = data;
                this.links = links;
              } catch (e) {
                console.log(e);
              }
            }
          }
        } else {
          alert('Please log in');
          this.$router.push('/login');
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
