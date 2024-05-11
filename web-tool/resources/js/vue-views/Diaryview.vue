<script setup>
import { ref } from "vue";
import BurgerMenu from "../components/diary/BurgerMenu.vue";
</script>

<template>
  <BurgerMenu />
  <div class="flex-box">
    <!--左側デザイン-->
    <div class="left-contents">
      <div class="fuction-box">
        <select class="color-select">
          <option value="">マーカー</option>
          <option value="">マーカー 赤</option>
          <option value="">マーカー 青</option>
          <option value="">マーカー 緑</option>
        </select>
        <select class="color-select">
          <option value="">文字色</option>
          <option value="">文字色 赤</option>
          <option value="">文字色 青</option>
          <option value="">文字色 緑</option>
        </select>
      </div>
      <div class="text-area">
        <textarea class="page-title" placeholder="ページタイトル"></textarea>
        <textarea class="page-text" placeholder="文章1"></textarea>
        <textarea class="page-text" placeholder="文章2"></textarea>
      </div>
    </div>
    <!--右側デザイン-->
    <div class="right-contents">
      <p>test</p>
    </div>
  </div>
  <!--ページ遷移-->
  <div class="page-transition">
    <button class="back-page">前のページ</button>
    <p class="page-count">0</p>
    <button class="next-page">次のページ</button>
  </div>
</template>

<style scoped>
.flex-box {
  display: flex;
  margin: 100px 20px 0 20px;
}

.left-contents {
  width: 50%;
  height: 100%;
  background-color: red;
}

.text-area {
  text-align: center;
}

.page-title {
  margin-top: 10px;
  text-align: center;
  font-size: 24px;
  width: 95%;
  padding-top: 20px;
  resize: none;
  cursor: pointer;
}

.page-text {
  margin-top: 20px;
  width: 90%;
  height: 245px;
  font-size: 24px;
  cursor: pointer;
  resize: none;
}

.left-contents textarea::selection {
  background-color: yellow;
  color: red;
}

.fuction-box {
  display: flex;
}

select {
  width: 100%;
  height: 50px;
  cursor: pointer;
}

.right-contents {
  width: 50%;
  background-color: blue;
}

.page-transition {
  display: flex;
  position: fixed;
  width: 100%;
  bottom: 46px;
  justify-content: center;
  align-items: center;
  background-color: #5a646d;
  border-bottom: 1px solid #ced4da;
  border-top: 1px solid #ced4da;
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
.next-page:hover{
  background-color: #0056b3;
}

.page-count{
  padding: 3px 10px;
  border-radius: 50%;
  margin: 15px 10px;
  background-color: #ffffff;
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 480px) {
}

@-moz-document url-prefix() {
}
</style>
