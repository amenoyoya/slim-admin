<template>
  <div>
    <nav-bar></nav-bar>
    <section class="section">
      <router-view></router-view>
    </section>
  </div>
</template>

<script>
export default {
  mounted() {
    // ログイン画面にリダイレクト
    this.$router.push('/login/');
  }
}
</script>