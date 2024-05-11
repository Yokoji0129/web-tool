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
  router.push("/diaryBooksList");
};
</script>

<template>
  <div>
    <header>
      <!--メニュー欄-->
      <nav :class="{ open: menuOpen }" @click="closeMenu">
        <!--メニューアイコン-->
        <div class="hamburger-icon-menu" @click="toggleMenu()"></div>
        <p class="back-page" @click="backPage">←日記一覧に戻る</p>
        <!--menuOpenがtrueの時だけ背景色変える-->
        <h3 class="diary-title" :style="{ backgroundColor: menuOpen ? '#ced4da' : 'initial' }">
          日記タイトル
        </h3>
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
  top: 20px;
  right: 20px;
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
  position: fixed;
  left: 20px;
  margin: 20px 10px 16px 0;
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
  top: 0;
  left: -400px;
  height: 100vh;
  width: 400px;
  display: flex;
  flex-direction: column;
  transition: 0.3s;
  z-index: 999;
}

nav p {
  margin: 0;
  padding: 0;
}

.nav-link {
  cursor: pointer;
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
  margin: 82px 0 5px 0;
  padding: 5px 0;
  background-color: #ced4da;
}

.table-contents {
  margin: 5px 10px;
  font-family: "Georgia", serif;
}

.username {
  background-color: #ced4da;
  margin-top: 5px;
  margin-bottom: 0;
  padding: 5px;
  text-align: center;
}

.open {
  left: 0;
  background-color: #ffffff;
  transition: 0.3s;
  border-right: 2px solid #ced4da;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
  .back-page {
    top: 25px;
    padding: 5px;
  }

  nav {
    top: -10px;
    width: 350px;
  }

  .diary-title {
    margin: 72px 0 5px 0;
  }
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 480px) {
  .back-page {
    top: 25px;
  }

  .hamburger-icon,
  .hamburger-icon-menu {
    width: 40px;
    height: 40px;
  }

  .open{
    width: 100%;
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
}
</style>
