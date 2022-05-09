<template>
  <div>
    <div>Email текущего пользователя:</div>
    <div>{{ user.email }}</div>
    <button v-on:click="loginAction">Войти</button>
    <button>Выйти</button>
  </div>
</template>

<script>

export default {
  name: "login",
  methods: {
    loginAction: function () {
      const email = '';
      const password = '';

      this.$axios.$post(
       '/v1/auth/login',
       {
         'email': email,
         'password': password,
       }
     ).then(function (res) {

      }).catch(function (e) {

      });
    }
  },
  async mounted() {
    this.$axios.$get('/v1/auth/me/').then(function (res) {
      this.user = res.user;
    });
  },
  data() {
    return {
      user: {
        email: ''
      }
    }
  }
}
</script>
