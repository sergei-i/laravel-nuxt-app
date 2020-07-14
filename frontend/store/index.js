// from Nuxt Auth module
export const getters = {
  authenticated: state => state.auth.loggedIn,
  user: state => state.auth.user
}
