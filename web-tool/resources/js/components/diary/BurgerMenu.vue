<script setup>
import { RouterLink, useRouter } from "vue-router";
import { ref } from "vue";

const props = defineProps({
  diary: Array,
  selectBookNumber: String,
  pages: Array,
  pageData: Object,
});
const emit = defineEmits(["update:currentPageIndex"]);
const router = useRouter();
const menuOpen = ref(false);
//ハンバーガーメニューの開閉
const toggleMenu = () => {
  menuOpen.value = !menuOpen.value;
};
//日記一覧に戻る
const backPage = () => {
  router.push("/diaryBooksList");
};

//押したタイトルのページに飛ぶメソッド
const jumpToPage = (pageIndex) => {
  //currentPageIndexを子コンポーネント操作するためにemit使用
  emit("update:currentPageIndex", pageIndex);

  const currentPage = props.pages[pageIndex][0];
  //取得したページのデータを表示用の変数に設定
  props.pageData.pageTitle = currentPage.page_title;
  props.pageData.pageText1 = currentPage.page_txt1;
  props.pageData.pageText2 = currentPage.page_txt2;

  //ページに飛んだ時にhamburgerメニュー閉じる
  toggleMenu();
};
</script>

<template>
  <div>
    <!--メニュー欄-->
    <nav :class="{ open: menuOpen }">
      <!--メニューアイコン-->
      <div class="hamburger-icon-menu" :class="{ 'hamburger-icon-menu-close': menuOpen }" @click="toggleMenu()"></div>
      <p class="back-page" @click="backPage">←日記一覧に戻る</p>
      <!--[]?を使ってundefinedのエラー回避-->
      <h3 class="diary-title">
        {{ diary[selectBookNumber]?.[0]?.diary_name }}
      </h3>
      <h3 class="table-contents">目次</h3>
      <div style="overflow-y: scroll;">
        <div class="table-contents-box" v-for="(page, index) in pages" :key="index">
          <p class="nav-link" @click="jumpToPage(index)">
            {{ index + 1 }}. {{ page[0].page_title }}
          </p>
        </div>
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
  background-color: rgba(0, 0, 0, 0.5);
}

.hamburger-icon-menu {
  cursor: pointer;
  background-size: contain;
  width: 40px;
  height: 40px;
  position: fixed;
  top: 5px;
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
  top: 0px;
  left: -400px;
  height: 100vh;
  width: 400px;
  display: flex;
  flex-direction: column;
  transition: 0.3s;
  background-color: #ffffff;
  z-index: 9999;
}

nav p {
  margin: 0;
  padding: 0;
}

.nav-link {
  cursor: pointer;
  padding: 15px 10px;
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
  font-size: 24px;
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

  .hamburger-icon-menu {
    width: 35px;
    height: 35px;
    left: 10px;
    top: -8px;
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

@-moz-document url-prefix() {
  .back-page {
    top: 16px;
  }

  .hamburger-icon-menu {
    top: 0px
  }

  nav {
    top: 0px;
  }

  .diary-title {
    margin: 72px 0 5px 0;
  }

  @media screen and (max-width: 768px) {
    .back-page {
      top: 25px;
      padding: 5px;
    }

    .hamburger-icon-menu {
      width: 35px;
      height: 35px;
      left: 10px;
      top: -8px;
      margin: 20px 10px 16px 0;
    }

    nav {
      top: -8px;
      width: 350px;
    }
  }
}
</style>
