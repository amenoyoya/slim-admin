<template>
<section class="section">
  <router-view></router-view>
</section>
</template>

<script>
export default {
  mounted() {
    // ログイン画面にリダイレクト
    this.$router.push('/login/');
  }
}
</script>