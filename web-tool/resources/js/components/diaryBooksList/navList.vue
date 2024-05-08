<script setup>
import { onMounted, ref } from "vue";
import { RouterLink, useRouter } from "vue-router";
const props = defineProps({
  books: Array,
  displayFavoriteBooks: Function,
  isFavoriteDisplayed: Boolean,
});

const showTooltip = ref(false);
const toggleTooltip = () => {
  showTooltip.value = !showTooltip.value;
};

const showTooltip2 = ref(false);
const toggleTooltip2 = () => {
  showTooltip2.value = !showTooltip2.value;
};

const showTooltip3 = ref(false);
const toggleTooltip3 = () => {
  showTooltip3.value = !showTooltip3.value;
};

const isSorted = ref(false); //50音順の表示切替のフラグ

// 日記を50音順にする
const sortJa = () => {
  if (!isSorted.value) {
    isSorted.value = true;
    props.books.sort((a, b) => {
      return a[0].diary_name.localeCompare(b[0].diary_name, "ja");
    });
  } else {
    isSorted.value = false;
    props.books.sort((a, b) => {
      return a[0].diary_id - b[0].diary_id;
    });
  }
};

const accountName = ref("");
const loadingLogin = ref(false);

//アカウント名取得
const account = () => {
  axios
    .get("/searchname")
    .then((response) => {
      accountName.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

const router = useRouter();

//ログアウトメソッド
const logout = () => {
  loadingLogin.value = true;
  axios
    .post("/logout", {})
    .then((response) => {
      router.push("/");
    })
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {
      loadingBook.value = false;
    });
};

onMounted(() => {
  account();
});
</script>

<!--日記本一覧ページのnavlist-->
<template>
  <nav class="fixed-nav">
    <ul class="nav-list">
      <!--利用注意-->
      <li class="nav-item-left">
        <p class="p" @click="toggleTooltip">利用注意</p>
      </li>
      <div class="tooltip" v-show="showTooltip">
        <fieldset>
          このサービスは勉強用に作成されたものです。<br />
          このサービスに保存できる情報量には限界があります。<br />
          予めご了承ください
        </fieldset>
      </div>
      <!--日記本-->
      <li class="nav-item-center">
        <p class="p" @click="toggleTooltip2">
          {{ isFavoriteDisplayed ? "お気に入り日記本" : "日記本" }}
          ({{ books.length }}冊)
        </p>
      </li>
      <div class="tooltip2" v-show="showTooltip2">
        <fieldset>
          <p class="diary-sort">日記並べ替え</p>
          <button class="sort" @click="displayFavoriteBooks">
            <!--isFavoriteDisplayedがtrueになったら通常表示に切り替え-->
            {{ isFavoriteDisplayed ? "通常表示" : "お気に入り表示" }}
          </button>
          <div>
            <button class="sort" @click="sortJa" v-if="!isSorted">
              50音順
            </button>
            <button class="sort" @click="sortJa" v-else>50音順解除</button>
          </div>
        </fieldset>
      </div>
      <!--ユーザー名-->
      <li class="nav-item-right">
        <p class="p" @click="toggleTooltip3">ユーザー名: {{ accountName }}</p>
      </li>
      <div class="tooltip3" v-show="showTooltip3">
        <fieldset>
          <button class="logout" @click="logout">ログアウト</button>
        </fieldset>
      </div>
    </ul>
  </nav>
  <!-- ローディングアニメーション -->
  <div v-if="loadingLogin" class="loading-overlay">
    <div class="spinner"></div>
  </div>
</template>

<style scoped>
.diary-sort {
  font-weight: bold;
  cursor: pointer;
}

.sort {
  cursor: pointer;
  margin-top: 10px;
  background-color: #ced4da;
  padding: 7px 0;
  width: 100%;
  border: none;
  transition: background-color 0.3s;
}

.sort:hover {
  background-color: #a9aeb3;
}

.fixed-nav {
  text-align: center;
  margin-top: 82px;
  position: fixed;
  top: 0;
  width: 100%;
  background-color: #ffffff;
  z-index: 999;
  border-bottom: 1px solid #ced4da;
}

.nav-list {
  background-color: #ffffff;
  list-style-type: none;
  padding: 0;
  margin: 0;
  display: flex;
  justify-content: space-between;
}

.nav-list .p {
  margin: 0;
  padding: 20px;
}

.nav-item-left,
.nav-item-center,
.nav-item-right {
  flex: 1;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.5s;
}

.nav-item-left:hover,
.nav-item-center:hover,
.nav-item-right:hover {
  background-color: #ced4da;
}

.tooltip {
  position: absolute;
  width: 25%;
  top: 100%;
  left: 0;
  background-color: #ffffff;
  padding: 5px 3px;
  border-right: 1px solid #ced4da;
  border-bottom: 1px solid #ced4da;
  z-index: 3;
}

.tooltip2 {
  position: absolute;
  width: 15%;
  top: 100%;
  left: 33.3%;
  background-color: #ffffff;
  padding: 5px 3px;
  border-right: 1px solid #ced4da;
  border-left: 1px solid #ced4da;
  border-bottom: 1px solid #ced4da;
  z-index: 2;
}

.tooltip3 {
  position: absolute;
  width: 15%;
  top: 100%;
  left: 66.6%;
  background-color: #ffffff;
  padding: 5px 3px;
  border-right: 1px solid #ced4da;
  border-left: 1px solid #ced4da;
  border-bottom: 1px solid #ced4da;
  z-index: 1;
}

.logout {
  cursor: pointer;
  margin-top: 7px;
  padding: 7px 0;
  width: 100%;
  background-color: #ced4da;
  border: none;
  transition: background-color 0.3s;
}

.logout:hover {
  background-color: #a9aeb3;
}

/*タブレット(1024px以下)*/
@media screen and (max-width: 1024px) {
  .tooltip,
  .tooltip2,
  .tooltip3 {
    width: 25%;
  }
}
/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
  .fixed-nav {
    margin-top: 62px;
  }

  .nav-list {
    flex-direction: column;
    align-items: center;
  }

  .nav-list .p {
    padding: 10px;
  }

  .nav-item-left,
  .nav-item-center,
  .nav-item-right {
    flex: none;
    width: auto;
  }

  .tooltip {
    left: 50%;
    top: 33%;
    width: 90%;
    border: 1px solid #ced4da;
    transform: translateX(-50%);
  }

  .tooltip2 {
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    top: 67%;
    border: 1px solid #ced4da;
  }

  .tooltip3 {
    border: 1px solid #ced4da;
    width: 90%;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
  }
}

/**firefox用のデザイン**/
@-moz-document url-prefix() {
  .tooltip {
    bottom: -85%;
  }
  .fixed-nav {
    margin-top: 82px;
  }
  @media screen and (max-width: 768px) {
    .fixed-nav {
      margin-top: 62px;
    }
    .tooltip {
      left: 50%;
      bottom: 0%;
      width: 50%;
      transform: translateX(-50%);
    }
    .tooltip2 {
      width: 163px;
      top: 66%;
      padding: 0px;
    }
  }
}
</style>