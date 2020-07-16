<template>
  <div class="container col-md-6 mt-5">
    <h2>Login</h2>
    <form @submit.prevent="submit">
      <div class="form-group">
        <label>Email address</label>
        <input
          v-model.trim="form.email"
          type="email"
          class="form-control"
          placeholder="Enter email"
          autofocus
        >
        <template v-if="errors.email">
          <small class="form-text text-danger" v-for="error in errors.email">
            {{ error }}
          </small>
        </template>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input
          v-model.trim="form.password"
          type="password"
          class="form-control"
          placeholder="Password"
        >
        <template v-if="errors.password">
          <small class="form-text text-danger" v-for="error in errors.password">
            {{ error }}
          </small>
        </template>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <p>
      Don't have an account?
      <nuxt-link to="/register">Register</nuxt-link>
    </p>
  </div>
</template>

<script>
  export default {
    middleware: ['guest'],
    data() {
      return {
        form: {
          email: '',
          password: ''
        }
      }
    },
    methods: {
      async submit() {
        try {
          // $auth because of Nuxt Auth module, 'local' because of nuxt config settings
          await this.$auth.loginWith('local', {data: this.form});

          this.$router.push({
            path: this.$route.query.redirect || '/dashboard'
          });
        } catch (err) {
          //TODO
          console.log(err)
        }
      }
    }
  }
</script>
