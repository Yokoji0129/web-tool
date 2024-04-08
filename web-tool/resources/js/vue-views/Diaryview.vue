<script setup>
import { ref } from "vue";
const menuOpen = ref(false);

//ハンバーガーメニューの開閉
const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};
</script>

<template>
  <div class="book-layout">
    <nav :class="{ open: menuOpen }">
      <!--メニューアイコン-->
      <div class="hamburger-icon-menu" @click="toggleMenu()"></div>
      <div>
        <h3 class="book-title">本の表紙タイトル</h3>
      </div>
      <div>
        <p class="nav-title">1.タイトル</p>
        <p class="nav-title">2.タイトル</p>
        <p class="nav-title">3.タイトル</p>
        <p class="nav-title">4.タイトル</p>
        <p class="nav-title">5.タイトル</p>
        <p class="nav-title">6.タイトル</p>
        <p class="nav-title">1.タイトル</p>
        <p class="nav-title">2.タイトル</p>
        <p class="nav-title">3.タイトル</p>
        <p class="nav-title">4.タイトル</p>
        <p class="nav-title">5.タイトル</p>
        <p class="nav-title">6.タイトル</p>
      </div>
    </nav>

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
.hamburger-icon,
.hamburger-icon-menu {
  cursor: pointer;
  background-size: contain;
  width: 50px;
  height: 50px;
  background-image: url(../../../public/testImage/bars_hoso.png);
  align-self: flex-end;
  margin: 10px;
  transition: 0.3s;
}

.hamburger-icon:hover,
.hamburger-icon-menu:hover {
  transform: scale(1.1);
  transition: 0.3s ease;
}

nav {
  position: fixed;
  left: -230px;
  height: 100%;
  width: 300px;
  background-color: #7bbbff;
  display: flex;
  flex-direction: column;
  transition: 0.3s;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/**ハンバーガメニュー開いたとき**/
.open {
  left: 0;
  background-color: #ffffff;
  transition: 0.3s;
}

.book-title {
  margin: 0;
  text-align: center;
  padding: 5px 0;
  color: #2f3439;
  font-family: "Georgia", serif;
}

.nav-title {
  cursor: pointer;
  padding: 0 10px;
}

.book-layout {
  margin-top: 90px;
  display: flex;
}

.left-page {
  margin-top: 40px;
  flex: 1;
  padding: 30px 30px 30px 90px;
}

.right-page {
  margin-top: 25px;
  flex: 1;
  padding: 30px;
}

.page-title-box {
  text-align: center;
}

.page-title {
  font-family: "Georgia", serif;
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
  font-family: "Georgia", serif;
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
  nav {
    top: 92px;
  }
  .book-layout {
    flex-direction: column;
    margin-top: 65px;
    margin-bottom: 60px;
  }
  .left-page {
    padding-bottom: 0;
  }
  .right-page {
    padding-left: 90px;
    margin-top: 0;
  }
  .page-text {
    padding-bottom: 35%;
  }
  .page-title {
    height: 60px;
  }
}

/**タブレット(ここから画像一列)**/
@media screen and (max-width: 768px) {
  nav {
    top: 62px;
  }
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
  .hamburger-icon,
  .hamburger-icon-menu {
    margin: 0px;
  }
  /***スマホの時はハンバーガメニュー全画面にする*/
  nav {
    left: -87%;
    width: 100%;
  }
  .book-layout {
    margin-top: 30px;
  }
  .left-page {
    padding-left: 70px;
  }
  .right-page {
    padding-left: 70px;
  }
  .page-title {
    height: 40px;
  }
  .page-text {
    padding-bottom: 80%;
  }
}
/**firefox用のデザイン**/
@-moz-document url-prefix() {
  nav{
    top: 82px;
  }
  @media screen and (max-width: 768px){
    nav{
      top: 62px;
    }
  }
}
</style>
