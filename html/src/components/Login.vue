<template>
  <div class="container">
    <h1 class="title">ログイン画面</h1>
    <div class="field">
      <label for="username" class="label">Username</label>
      <div class="control">
        <input id="username" class="input" type="text" v-model="username">
      </div>
    </div>
    <div class="field">
      <label for="password" class="label">Password</label>
      <div class="control">
        <input id="password" class="input" type="password" v-model="password">
      </div>
    </div>
    <div>
      <button class="button is-primary" @click.prevent="login()">Login</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: '',
      token: ''
    };
  },
  methods: {
    login() {
      const csrf = document.getElementById('csrf').value;
      axios.post('/api/login/', {csrf: csrf, username: this.username, password: this.password})
        .then((res) => {
          if (res.data.login) {
            this.token = res.data.token; // 認証トークン
            this.$router.push('/dashboard/');
          } else {
            alert(res.data.message);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    }
  }
}
</script>
