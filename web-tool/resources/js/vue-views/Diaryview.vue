<script setup>
import { RouterLink, useRouter } from "vue-router";
import { ref } from "vue";
import NavList from "../components/diary/NavList.vue";
const menuOpen = ref(false);
const router = useRouter();

//ハンバーガーメニューの開閉
const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};

const backPage = () => {
  router.push("/diaryBooksList")
}
</script>

<template>
  <div>
    <header>
      <!--メニュー欄-->
      <nav :class="{ open: menuOpen }" @click="closeMenu">
        <!--メニューアイコン-->
        <div class="hamburger-icon-menu" @click="toggleMenu()"></div>
        <p class="back-page" @click="backPage">←日記一覧に戻る</p>
        <h3 class="diary-title">日記タイトル</h3>
        <h3 class="table-contents">目次</h3>
        <!--目次内容(menuOpenがtrueでスクロールできるようにする)-->
        <div class="table-contents-box" :style="{ overflow: menuOpen ? 'scroll' : 'hidden' }">
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
          <p class="nav-link">0.test</p>
        </div>
      </nav>
    </header>
  </div>
</template>

<style scoped>
.back-page {
  cursor: pointer;
  position: absolute;
  top: 3px;
  left: 3px;
  padding: 10px;
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border-radius: 5px;
  transition: 0.3s;
}
.back-page:hover {
  background-color: rgba(74, 73, 73, 0.5);
}

.hamburger-icon,
.hamburger-icon-menu {
  cursor: pointer;
  background-size: contain;
  width: 40px;
  height: 40px;
  background-image: url(../../../public/icon/hamburger.png);
  align-self: flex-end;
  margin: 5px 10px 0 0;
  transition: 0.3s;
}

.hamburger-icon:hover,
.hamburger-icon-menu:hover {
  transform: scale(1.1);
  transition: 0.3s ease;
}

.hamburger-icon:focus,
.hamburger-icon-menu:focus {
  outline: none;
}

nav {
  position: fixed;
  top: 82px;
  left: -340px;
  height: 100vh;
  width: 400px;
  background-color: #ced4da;
  display: flex;
  flex-direction: column;
  transition: 0.3s;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

nav p {
  margin: 0;
  padding: 0;
}

.nav-link {
  padding: 10px;
  text-decoration: none;
  color: black;
  transition: 0.3s;
  font-family: "Georgia", serif;
}

.nav-link:hover {
  background-color: #ced4da;
}

.diary-title {
  text-align: center;
  font-family: "Georgia", serif;
  margin: 5px 0;
  padding: 5px 0;
  background-color: #ced4da;
}

.table-contents {
  margin: 5px 10px;
  font-family: "Georgia", serif;
}

.table-contents-box {
  max-height: 70%;
  /**目次の高さが30%まで行ったらスクロールできるように**/
}

.username {
  background-color: #ced4da;
  margin-top: 5px;
  margin-bottom: 0;
  padding: 5px;
  text-align: center;
}

.logout {
  cursor: pointer;
  padding: 7px 0;
  width: 100%;
  background-color: #ced4da;
  border: none;
  transition: background-color 0.3s;
}

.logout:hover {
  background-color: #a9aeb3;
}

.open {
  left: 0;
  background-color: #ffffff;
  transition: 0.3s;
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {

  .hamburger-icon,
  .hamburger-icon-menu {
    width: 40px;
    height: 40px;
  }

  nav {
    top: 62px;
    left: -290px;
    width: 350px;
  }
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 450px) {

  .hamburger-icon,
  .hamburger-icon-menu {
    width: 40px;
    height: 40px;
  }

  nav {
    left: -290px;
  }
}

@-moz-document url-prefix() {
  nav {
    top: 72px;
  }

  @media screen and (max-width: 768px) {
    nav {
      top: 62px;
    }
  }
}</style>
