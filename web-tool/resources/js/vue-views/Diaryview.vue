<script setup>
import { ref } from "vue";
import NavList from "../components/diary/NavList.vue";
const menuOpen = ref(false);

//ハンバーガーメニューの開閉
const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};
</script>

<template>
  <div>
    <header>
      <!--メニュー欄-->
      <nav :class="{ open: menuOpen }" @click="closeMenu">
        <!--メニューアイコン-->
        <div class="hamburger-icon-menu" @click="toggleMenu()"></div>
        <h1 class="diary-title">日記タイトル</h1>
        <h2 class="table-contents">目次</h2>
        <!--目次内容(menuOpenがtrueでスクロールできるようにする)-->
        <div
          class="table-contents-box"
          :style="{ overflow: menuOpen ? 'scroll' : 'hidden' }"
        >
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
        <!--ユーザー情報-->
        <h2 class="username">ユーザー名: test</h2>
      </nav>
    </header>
  </div>
</template>

<style scoped>
.hamburger-icon,
.hamburger-icon-menu {
  cursor: pointer;
  background-size: contain;
  width: 60px;
  height: 60px;
  background-image: url(../../../public/icon/bars_hoso.png);
  align-self: flex-end;
  margin: 10px 10px 0 0;
  transition: 0.3s;
}

.hamburger-icon:hover,
.hamburger-icon-menu:hover {
  transform: scale(1.2);
  transition: 0.3s ease;
}

.hamburger-icon:focus,
.hamburger-icon-menu:focus {
  outline: none;
}

nav {
  position: fixed;
  top: 82px;
  left: -325px;
  height: 100vh;
  width: 400px;
  background-color: #ebebeb;
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
}

.nav-link:hover {
  background-color: #ebebeb;
}

.diary-title {
  text-align: center;
  margin: 5px 0;
  padding: 5px 0;
  background-color: #ebebeb;
}

.table-contents {
  margin: 5px 10px;
}

.table-contents-box {
  max-height: 30%; /**目次の高さが30%まで行ったらスクロールできるように**/
}

.username {
  background-color: #ebebeb;
  margin: 5px 0;
  padding: 5px;
  text-align: center;
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
    width: 50px;
    height: 50px;
  }
  nav {
    top: 62px;
    left: -280px;
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
    nav{
      top: 62px;
    }
  }
}
</style>
