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
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test.png" />
        <img src="../../../public/testImage/test.png" />
        <!--画像がないときに表示させる<h1>旅行での写真を入れてください</h1>-->
      </div>
    </div>
  </div>
</template>
  
<style scoped>
.book-layout {
  margin-top: 130px;
  display: flex;
}

.left-page {
  flex: 1;
  padding: 30px;
}

.right-page {
  flex: 1;
  padding: 30px;
}

.page-title-box {
  margin-top: 25px;
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
  resize: none; /**textareaのサイズをユーザーが帰れないように変更**/
}

.image-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  grid-gap: 10px;
}

.image-grid img {
  max-width: 100%;
  height: auto;
}

/**フルHD**/
@media screen and (max-width: 1980px) {
  .page-text {
    padding-bottom: 60%;
  }

  .image-grid img {
    max-width: 90%;
    height: auto;
  }
}

/**このサイズからページを縦に並べる**/
@media screen and (max-width: 1280px) {
  .book-layout {
    flex-direction: column;
    margin-top: 70px;
    margin-bottom: 60px;
  }

  /**縦並びになったときに幅を100%に戻す**/
  .image-grid img {
    max-width: 100%;
    height: auto;
  }
}

@media screen and (max-width: 700px) {
  .book-layout {
    margin-top: 40px;
    margin-bottom: 30px;
  }
  .title {
    margin-top: 72px;
    padding: 1px;
  }
  .image-grid {
    grid-template-columns: repeat(1, 1fr);
  }
  .page-title {
    height: 50px;
    font-size: 24px;
  }
  .page-text {
    padding-bottom: 100%;
    width: 100%;
    font-size: 16px;
  }
}
</style>
