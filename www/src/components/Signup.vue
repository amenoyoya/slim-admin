<template>
  <div class="container">
    <h1 class="title">ユーザー登録</h1>
    
    <transition
      name="custom-classes-transition"
      enter-active-class="animated fadeInUp"
      leave-active-class="animated fadeOutDown"
    >
      <div class="notification is-warning" v-if="warning !== ''">{{ warning }}</div>
      <div class="notification is-danger" v-if="error !== ''">{{ error }}</div>
    </transition>

    <form @submit.prevent="signup">
      <div class="field">
        <label for="username" class="label">Username</label>
        <div class="control">
          <input id="username" class="input" type="text" v-model="username" placeholder="admin">
        </div>
        <p class="is-size-7">※ユーザー名は15文字以内のアルファベットを指定してください</p>
      </div>
      <div class="field">
        <label for="password" class="label">Password</label>
        <div class="control">
          <input id="password" class="input" type="password" v-model="password">
          <p class="is-size-7">※パスワードは30文字以内で指定してください</p>
        </div>
      </div>
      <div>
        <button class="button is-link" type="submit">Sign up</button>
      </div>
    </form>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      warning: '',
      error: '',
      username: '',
      password: ''
    };
  },
  methods: {
    signup() {
      this.warning = '', this.error = '';
      /*axios.post('/api/login/', {
        csrf: document.getElementById('csrf').value, username: this.username, password: this.password
      })
        .then((res) => {
          if (res.data.auth) {
            this.$store.commit('authenticate', res.data);
            this.$router.push(this.$route.query.redirect || '/');
          } else {
            this.warning = res.data.message;
          }
        })
        .catch((err) => {
          this.error = 'サーバーエラー ' + err.response.status + ': ' + err.response.statusText;
        });
      */
     console.log(this.username, this.password);
    }
  }
}
</script>
