<script setup>
import { RouterLink, useRouter } from "vue-router";
import { ref } from "vue";
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
    <!--メニュー欄-->
    <nav :class="{ open: menuOpen }" @click="closeMenu">
      <!--メニューアイコン-->
      <div
        class="hamburger-icon-menu"
        :class="{ 'hamburger-icon-menu-close': menuOpen }"
        @click="toggleMenu()"
      ></div>
      <p class="back-page" @click="backPage">←日記一覧に戻る</p>
      <h3 class="diary-title">日記タイトル</h3>
      <h3 class="table-contents">目次</h3>
      <div class="table-contents-box">
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
  </div>
</template>

<style scoped>
.back-page {
  cursor: pointer;
  position: absolute;
  top: 20px;
  right: 20px;
  padding: 10px;
  background-color: rgba(74, 73, 73, 0.5); 
  color: white;
  border-radius: 5px;
  transition: 0.3s;
  z-index: 1;
}

.back-page:hover {
  background-color: rgba(0, 0, 0, 0.5);;
}

.hamburger-icon-menu {
  cursor: pointer;
  background-size: contain;
  width: 40px;
  height: 40px;
  position: fixed;
  left: 20px;
  background-image: url(../../../../public/icon/hamburger.png);
  margin: 17px 10px 16px 0;
  border-radius: 5px;
  transition: 0.3s;
  z-index: 2;
}
.hamburger-icon-menu-close {
  background-image: url(../../../../public/icon/close.png);
}

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
  top: 2px;
  left: -400px;
  height: 100vh;
  width: 400px;
  display: flex;
  flex-direction: column;
  transition: 0.3s;
  background-color: #ffffff;
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

.table-contents-box {
  overflow: scroll;
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

  .hamburger-icon-menu {
    width: 35px;
    height: 35px;
    left: 10px;
    margin: 20px 10px 16px 0;
  }

  nav {
    top: -8px;
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

  .open {
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
