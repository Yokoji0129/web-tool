<script setup>
import { ref } from "vue";
</script>

<template>
  <div class="book-layout">
    <div class="left-page">
      <div class="page-title-box">
        <input
          type="text"
          class="page-title"
          maxlength="100"
          placeholder="日記ページタイトル"
        />
      </div>
      <div class="page-text-box">
        <textarea class="page-text" placeholder="日記記入欄"></textarea>
      </div>
    </div>
    <div class="right-page">
      <div class="custom-file-input">
        <input class="file" type="file" />
      </div>
      <div class="image-grid">
        <img src="../../../public/testImage/test2.jpg" />
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test2.jpg" />
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test.png" />
        <!--画像がないときに表示させる<h1>旅行での写真を入れてください</h1>-->
      </div>
    </div>
  </div>
</template>
  
<style scoped>
.book-layout {
  margin-top: 90px;
  display: flex;
}

.left-page {
  margin-top: 35px;
  flex: 1;
  padding: 30px;
}

.right-page {
  margin-top: 20px;
  flex: 1;
  padding: 30px;
}

.page-title-box {
  text-align: center;
}

.page-title {
  width: 100%;
  height: 70px;
  font-size: 32px;
  text-align: center;
}

.page-text-box {
  margin-top: 20px;
  text-align: center;
}

.page-text {
  padding-bottom: 70%;
  width: 100%;
  font-size: 24px;
  resize: none; /**textareaのサイズをユーザーが変えれないように変更**/
}

.image-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 10px;
}

.image-grid img {
  max-width: 100%;
  height: 100%;
}

/**フルHD**/
@media screen and (max-width: 1920px) {
  .left-page {
    padding-top: 20px;
  }
  .page-text {
    padding-bottom: 60%;
  }

  .image-grid img {
    max-width: 90%;
  }
}

/**ノートパソコンLサイズ**/
@media screen and (max-width: 1440px) {
  .right-page {
    margin-top: 40px;
  }

  .page-text {
    padding-bottom: 75%;
  }

  .image-grid img {
    max-width: 100%;
  }
}

/**このサイズから左右ページを縦配置**/
@media screen and (max-width: 1400px) {
  .book-layout {
    flex-direction: column;
    margin-top: 65px;
    margin-bottom: 60px;
  }
  .left-page {
    padding-bottom: 0;
  }
  .right-page {
    margin-top: 0;
  }
  .page-text {
    padding-bottom: 35%;
  }
  .page-title{
    height: 60px;
  }
}

/**タブレット(ここから画像一列)**/
@media screen and (max-width: 768px) {
  .book-layout {
    margin-top: 35px;
    margin-bottom: 30px;
  }
  .image-grid {
    grid-template-columns: repeat(1, 1fr);
  }
  .page-title {
    height: 50px;
    font-size: 24px;
  }
  .page-text {
    padding-bottom: 60%;
    width: 100%;
    font-size: 16px;
  }
}

/**スマホ**/
@media screen and (max-width: 450px) {
  .book-layout {
    margin-top: 30px;
  }
  .page-title {
    height: 40px;
  }
  .page-text {
    padding-bottom: 80%;
  }
}
</style>
