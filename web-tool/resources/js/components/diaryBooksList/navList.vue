<script setup>
import { onMounted, ref } from "vue";
import { RouterLink, useRouter } from "vue-router";
const props = defineProps({
  books: Array,
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

const accountName = ref("");

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
  axios
    .post("/logout", {})
    .then((response) => {
      router.push("/");
    })
    .catch((error) => {
      console.log(error);
    });
};

onMounted(() => {
  account();
});
</script>

<template>
  <nav class="fixed-nav">
    <ul class="nav-list">
      <li class="nav-item-left">
        <p class="p" @click="toggleTooltip">利用注意</p>
        <div class="tooltip" v-show="showTooltip">
          このサービスは勉強用に作成されたものです、​
          このサービスに保存できる情報量には限界があります、予めご了承ください
        </div>
      </li>
      <li class="nav-item-center">
        <p class="p" @click="toggleTooltip2">
          日記本一覧({{ books.length }}冊)
        </p>
        <div class="tooltip2" v-show="showTooltip2">
          <p class="book-list" v-for="(book, index) in books" :key="index">
            {{ book[0].diary_name }}
          </p>
        </div>
      </li>
      <li class="nav-item-right">
        <p class="p" @click="toggleTooltip3">ユーザー名: {{ accountName }}</p>
        <div class="tooltip3" v-show="showTooltip3">
          <button class="logout" @click="logout">ログアウト</button>
        </div>
      </li>
    </ul>
  </nav>
</template>

<style scoped>
.fixed-nav {
  text-align: center;
  margin-top: 92px;
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
}

.nav-item-left:hover,
.nav-item-center:hover,
.nav-item-right:hover {
  background-color: #ced4da;
}

.tooltip {
  position: absolute;
  width: 32.5%;
  top: 100%;
  left: 33.4%;
  transform: translateX(-100%);
  background-color: #ced4da;
  padding: 5px 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  z-index: 3;
}

.tooltip2 {
  position: absolute;
  width: 15%;
  top: 100%;
  transform: translateX(-0%);
  background-color: #ced4da;
  padding: 5px 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  z-index: 2;
}

.tooltip3 {
  position: absolute;
  width: 15%;
  top: 100%;
  transform: translateX(-0%);
  background-color: #ced4da;
  padding: 5px 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  z-index: 1;
}

.book-list {
  margin: 10px 0;
}

.logout {
  padding: 10px 20px;
  background-color: #ffffff;
  border: none;
}

.logout:hover {
  background-color: #f8f9fa;
}

/*タブレット*/
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
    width: 100%;
    transform: translateX(-50%);
  }

  .tooltip2 {
    width: 154px;
    top: 67%;
    padding: 0px;
  }

  .book-list {
    margin: 0;
  }

  .tooltip3 {
    width: 100%;
    top: 100%;
    left: 0;
    padding: 5px 10px;
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