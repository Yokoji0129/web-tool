<script setup lang="ts">
import { defineProps } from 'vue';
const props = defineProps<{
  isLoading: boolean,
}>();
</script>

<template>
  <div v-if="props.isLoading" class="loading-overlay">
    <div class="spinner"></div>
  </div>
</template>

<style scoped>
/*ローディングアニメーション*/
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(184, 184, 184, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.spinner {
  border: 5px solid #f3f3f3;
  border-top: 5px solid #3498db;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  animation: spin 1s linear infinite;
}
</style>