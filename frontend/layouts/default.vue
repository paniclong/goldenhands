<template>
  <div>
    <NavBar/>
    <main>
      <nuxt/>
    </main>
  </div>
</template>

<script lang="ts">
import NavBar from "~/components/Navbar.vue";

export default {
  name: "Root",
  components: {
    NavBar
  }
}
</script>

<style scoped>

</style>
