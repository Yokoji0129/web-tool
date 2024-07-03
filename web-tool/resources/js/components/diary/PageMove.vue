<script setup>
import { ref } from "vue";
const props = defineProps({
  currentPageIndex: Number,
  pages: Array,
  currentPage: Function,
});
const emit = defineEmits(["update:currentPageIndex"]);
let inputPageNumber = ref(props.currentPageIndex);
let showInput = ref(false);
//前のページに移動するメソッド
const prevPage = () => {
  if (props.currentPageIndex > 0) {
    emit("update:currentPageIndex", props.currentPageIndex - 1);
    props.currentPage();
    //ページ移動したときに一番上に戻る(スマホ、タブレットの場合)
    window.scrollTo(0, 0);
  }
};

//次のページに移動するメソッド
const nextPage = () => {
  if (props.currentPageIndex < props.pages.length - 1) {
    emit("update:currentPageIndex", props.currentPageIndex + 1);
    props.currentPage();
    //ページ移動したときに一番上に戻る(スマホ、タブレットの場合)
    window.scrollTo(0, 0);
  }
};

//入力されたページに移動するメソッド
const goToPage = () => {
  if (props.pages.length) {
    emit("update:currentPageIndex", inputPageNumber.value - 1);
    props.currentPage();
    //ページ移動したときに一番上に戻る(スマホ、タブレットの場合)
    window.scrollTo(0, 0);
  }
  showInput.value = false;
};

//ページ入力を表示させるメソッド
const toggleInput = () => {
  showInput.value = !showInput.value;
  inputPageNumber.value = props.currentPageIndex + 1; //現在のページ番号を設定
};
</script>
<template>
  <div class="page-transition">
    <button class="back-page" @click="prevPage">前のページ</button>
    <p class="page-count" @click="toggleInput">
      {{ currentPageIndex + 1 }} / {{ pages.length }}
    </p>
    <button class="next-page" @click="nextPage">次のページ</button>
    <div v-if="showInput" class="input-container">
      <input type="number" v-model="inputPageNumber" min="1" :max="pages.length" />
      <button class="go-page" @click="goToPage">ページ移動</button>
    </div>
  </div>
</template>
<style scoped>
.input-container {
  position: fixed;
  bottom: 105px;
  padding: 10px 0;
  width: 100%;
  text-align: center;
  background-color: #5a646d;
}

input[type="number"] {
  width: 50px;
  padding: 5px;
  margin: 0 10px;
  border-radius: 5px;
  border: none;
}

.page-transition {
  display: flex;
  position: fixed;
  width: 100%;
  bottom: 45px;
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
  cursor: pointer;
}

@media screen and (max-width: 1024px) {
  .page-transition {
    bottom: 35px;
  }

  .input-container {
    bottom: 90px;
  }
}

@-moz-document url-prefix() {
  .page-transition {
    bottom: 40px;
  }

  .input-container {
    bottom: 92px;
  }

  @media screen and (max-width: 1024px) {

    .page-transition {
      bottom: 30px;
    }
  }
}
</style>