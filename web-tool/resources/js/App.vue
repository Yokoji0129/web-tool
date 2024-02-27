<script setup>
import { ref } from "vue";
const test = ref("テスト")
</script>

<template>
  <RouterLink to="/">home</RouterLink> |
  <RouterLink to="/about">about</RouterLink>
  <router-view />
  <p>{{ test }}</p>
</template>

