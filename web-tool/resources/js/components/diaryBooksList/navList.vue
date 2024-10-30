<script setup lang="ts">
import axios from "axios";
import { onMounted, ref } from "vue";
import { RouterLink, useRouter } from "vue-router";
import LoadingScreen from "../LoadingScreen.vue";

interface Book {
  diary_color: string;
  diary_favorite: number;
  diary_font: string;
  diary_id: number;
  diary_name: string;
  diary_text_color: string;
  diary_top_file: string;
}

const props = defineProps<{
  books: Book[],
  displayFavoriteBooks: () => void,
  isFavoriteDisplayed: boolean,
}>();

const isLoading = ref<boolean>(false)

const tooltipsVisible = ref<boolean[]>([false, false, false]); //ツールチップの表示状態を配列で管理

//メニュー内容の表示非表示
const toggleTooltip = (index: number): void => {
  //indexが一致したら値を反転させて、一致しなかった物はすべてfalseにする
  tooltipsVisible.value = tooltipsVisible.value.map((visible, i) => (i === index ? !visible : false));
  console.log(tooltipsVisible.value)
};

const isSorted = ref<boolean>(false); //50音順の表示切替のフラグ

//日記を50音順にする
const sortJa = (): void => {
  if (!isSorted.value) {
    //50音順
    isSorted.value = true;
    props.books.sort((a, b) => {
      return a[0].diary_name.localeCompare(b[0].diary_name, "ja");
    });
  } else {
    //日記作成順
    isSorted.value = false;
    props.books.sort((a, b) => {
      return a[0].diary_id - b[0].diary_id;
    });
  }
};


const accountName = ref<string>("");

//アカウント名取得
const account = async (): Promise<void> => {
  try {
    const response = await axios.get("/searchname");
    accountName.value = response.data;
  } catch (error) {
    console.log(error);
  }
};

const router = useRouter();

//ログアウトメソッド
const logout = async (): Promise<void> => {
  isLoading.value = true;

  try {
    await axios.post("/logout", {});
    router.push("/");
  } catch (error) {
    console.log(error);
  } finally {
    isLoading.value = false;
  }
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
        <p class="p" @click="toggleTooltip(0)">利用注意</p>
      </li>
      <div class="tooltip" v-show="tooltipsVisible[0]">
        <fieldset>
          このサービスは勉強用に作成されたものです。<br />
          このサービスに保存できる情報量には限界があります。<br />
          予めご了承ください
        </fieldset>
      </div>
      <!--日記本-->
      <li class="nav-item-center">
        <p class="p" @click="toggleTooltip(1)">
          {{ isFavoriteDisplayed ? "お気に入り日記本" : "日記本" }}
          ({{ books.length }}冊)
        </p>
      </li>
      <div class="tooltip2" v-show="tooltipsVisible[1]">
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
        <p class="p" @click="toggleTooltip(2)">ユーザー名: {{ accountName }}</p>
      </li>
      <div class="tooltip3" v-show="tooltipsVisible[2]">
        <fieldset>
          <button class="logout" @click="logout">ログアウト</button>
        </fieldset>
      </div>
    </ul>
  </nav>
  <!-- ローディングアニメーション -->
  <LoadingScreen :isLoading="isLoading" />
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
  .fixed-nav {
    margin-top: 72px;
  }
  @media screen and (max-width: 768px) {
    .fixed-nav {
      margin-top: 61.5px;
    }
  }
}
</style>