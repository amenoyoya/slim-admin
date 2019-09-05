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
      password: ''
    };
  },
  methods: {
    login() {
      // console.log(this.username);
      // console.log(this.password);
      const csrf = document.getElementById('csrf').value;
      console.log(csrf);
      axios.post('/api_test/', {csrf: csrf})
        .then((res) => {
          console.log(res);
          // this.$router.push('/dashboard/');
        })
        .catch((err) => {
          console.log(err);
        });
    }
  }
}
</script>
