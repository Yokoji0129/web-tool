<script setup>
const props = defineProps({
  books: Array,
  togglePopup: Function
});
</script>

<template>
  <div class="diaries">
    <!--作成した本のリスト-->
    <div
      v-for="(book, index) in books"
      :key="index"
      class="diary"
      :style="{ backgroundColor: book[0].diary_color }"
    >
      <h2 :style="{ color: book[0].diary_text_color }">
        {{ book[0].diary_name }}
      </h2>
    </div>
    <div class="diary" @click="togglePopup">
      <h2>+</h2>
    </div>
  </div>
</template>

<style scoped>
.diaries {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 20px;
}

.diary {
  text-align: center;
  border: 2px solid #ccc;
  padding: 70px 0 280px 0;
  margin-top: 30px;
  background-color: #d4d4d4;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  cursor: pointer;
}

.diary h2 {
  margin: 0;
}

/*ウィンドウ幅が580px以下の場合のnavのスタイル(本の横幅調整。このタイミングでやらないと本が正方形になる)*/
@media screen and (max-width: 580px) {
  .diaries {
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  }
}
</style>