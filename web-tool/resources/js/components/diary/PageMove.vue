<script setup>
const props = defineProps({
  currentPageIndex: Number,
  pages: Array,
  currentPage: Function,
});
const emit = defineEmits(["update:currentPageIndex"]);
//前のページに移動するメソッド
const prevPage = () => {
  if (props.currentPageIndex > 0) {
    emit("update:currentPageIndex", props.currentPageIndex - 1);
    props.currentPage();
  }
};

//次のページに移動するメソッド
const nextPage = () => {
  if (props.currentPageIndex < props.pages.length - 1) {
    emit("update:currentPageIndex", props.currentPageIndex + 1);
    props.currentPage();
  }
};
</script>
<template>
  <div class="page-transition">
    <button class="back-page" @click="prevPage">前のページ</button>
    <p class="page-count">{{ currentPageIndex + 1 }} / {{ pages.length }}</p>
    <button class="next-page" @click="nextPage">次のページ</button>
  </div>
</template>
<style scoped>
.page-transition {
  display: flex;
  position: fixed;
  width: 100%;
  bottom: 46px;
  justify-content: center;
  align-items: center;
  background-color: #5a646d;
}
.back-page,
.next-page {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease;
}

.back-page:hover,
.next-page:hover {
  background-color: #0056b3;
}

.page-count {
  padding: 3px 10px;
  border-radius: 50px;
  margin: 15px 10px;
  background-color: #ffffff;
}
@media screen and (max-width: 1024px) {
  .page-transition {
    bottom: 35px;
  }
}
</style>