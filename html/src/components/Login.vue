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
export default {
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    login() {
      console.log(this.username);
      console.log(this.password);
      this.$router.push('/dashboard/');
    }
  }
}
</script>
