<template>
  <div class="container col-md-6 mt-5">
    <h2>Register</h2>
    <form @submit.prevent="submit">
      <div class="form-group">
        <label>Full name</label>
        <input
          v-model.trim="form.name"
          type="text"
          class="form-control"
          placeholder="Enter your name"
          autofocus
        >
        <template v-if="errors.name">
          <small class="form-text text-danger" v-for="error in errors.name">
            {{ error }}
          </small>
        </template>
      </div>
      <div class="form-group">
        <label>Email address</label>
        <input
          v-model.trim="form.email"
          type="email"
          class="form-control"
          placeholder="Enter email"
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
      <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p>
      Already have an account?
      <nuxt-link to="/login">Login</nuxt-link>
    </p>
  </div>
</template>

<script>
  export default {
    middleware: ['guest'],
    data() {
      return {
        form: {
          name: '',
          email: '',
          password: ''
        }
      }
    },
    methods: {
      async submit() {
        try {
          await this.$axios.post('api/register', this.form);
          await this.$auth.loginWith('local', {
            data: {
              email: this.form.email,
              password: this.form.password
            }
          });

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
