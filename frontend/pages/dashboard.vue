<template>
  <div class="container col-md-6 mt-5">
    <h2>Create a new topic</h2>
    <form @submit.prevent="create">
      <div class="form-group">
        <label>Topic title</label>
        <input
          v-model="form.title"
          type="text"
          class="form-control"
          placeholder="Enter topic title"
          autofocus
        >
        <template v-if="errors.title">
          <small class="form-text text-danger" v-for="error in errors.title">
            {{ error }}
          </small>
        </template>
      </div>
      <div class="form-group">
        <label>Topic body</label>
        <textarea v-model="form.body" class="form-control" rows="5">

        </textarea>
        <template v-if="errors.body">
          <small class="form-text text-danger" v-for="error in errors.body">
            {{ error }}
          </small>
        </template>
      </div>
      <button type="submit" class="btn btn-primary">Create</button>
    </form>
  </div>
</template>

<script>
  export default {
    middleware: ['auth'],
    data() {
      return {
        form: {
          title: '',
          body: ''
        }
      }
    },
    methods: {
      async create() {
        try {
          await this.$axios.$post('api/topics', this.form);

          this.$router.push('/');
        } catch (err) {
          //TODO
          console.log(err)
        }
      }
    }
  }
</script>
