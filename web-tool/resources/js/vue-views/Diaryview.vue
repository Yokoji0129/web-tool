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
      <p>右側</p>
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
  border: 1px solid #ced4da;
  border-radius: 5px;
}
.page-title:hover {
  border-color: #9aa0a7;
}

.page-text {
  margin-top: 20px;
  width: 93%;
  height: 410px;
  font-size: 24px;
  line-height: 1.5;
  cursor: pointer;
  resize: none;
  padding: 10px;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.page-text:hover {
  border-color: #9aa0a7;
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
  border-radius: 50%;
  margin: 15px 10px;
  background-color: #ffffff;
}

/**デスクトップのtextarea調整**/
@media screen and (max-width: 1980px) {
  .page-text {
    height: 230px;
  }
}

/**ノートパソコンのtextarea調整**/
@media screen and (max-width: 1600px) {
  .page-text {
    height: 135px;
  }
}

@media screen and (max-width: 1024px) {
  .flex-box {
    margin: 82px 0;
    flex-direction: column;
  }
  .color-select {
    margin-bottom: 8px;
  }
  .left-contents {
    width: 100%;
  }
  .right-contents {
    width: 100%;
  }
  .page-text {
    margin-top: 10px;
    height: 250px;
  }
  .page-transition {
    bottom: 35px;
  }
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
  .flex-box {
    margin: 62px 0;
    flex-direction: column;
  }
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 480px) {
  .page-title {
    margin: 0;
    font-size: 20px;
  }
  .page-text {
    margin-top: 5px;
    font-size: 16px;
    width: 90%;
  }
}

@-moz-document url-prefix() {
}
</style>
