<script setup>
import { onMounted, ref } from "vue";
const props = defineProps({
  books: Array,
});

const showTooltip = ref(false); //注意書きの表示制御

const toggleTooltip = () => {
  showTooltip.value = !showTooltip.value;
};

const accountName = ref("");

//アカウント名取得
const account = () => {
  axios
    .get("/searchname")
    .then((response) => {
      accountName.value = response.data;
      console.log(response.data);
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
        <p @click="toggleTooltip">利用注意</p>
        <div class="tooltip" v-show="showTooltip">
          このサービスは勉強用に作成されたものです、​
          このサービスに保存できる情報量には限界があります、予めご了承ください
        </div>
      </li>
      <li class="nav-item-center">
        <p>日記本一覧({{ books.length }}冊)</p>
      </li>
      <li class="nav-item-right">
        <p>アカウント名: {{ accountName }}</p>
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

.nav-list p {
  margin: 0;
  padding: 20px;
}

.nav-item-left,
.nav-item-center,
.nav-item-right {
  flex: 1;
  font-weight: bold;
}

.nav-item-left {
  cursor: pointer;
}

.tooltip {
  position: absolute;
  width: 30%;
  bottom: -92%;
  left: 33%;
  transform: translateX(-100%);
  background-color: #8795a1;
  padding: 5px 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
/**注意書き文字改行調整**/
@media screen and (max-width: 1492px) {
  .tooltip {
    bottom: -129%;
  }
}
/**注意書き文字改行調整**/
@media screen and (max-width: 1012px) {
  .tooltip {
    bottom: -165%;
  }
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

  .nav-list p {
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
    bottom: 0%;
    width: 50%;
    transform: translateX(-50%);
  }
}

/**注意書き文字改行調整**/
@media screen and (max-width: 607px) {
  .tooltip {
    width: 60%;
  }
}
/**注意書き文字改行調整**/
@media screen and (max-width: 506px) {
  .tooltip {
    width: 70%;
  }
}

/**スマホ**/
@media screen and (max-width: 450px) {
  .tooltip {
    width: 90%;
  }
}
/**注意書き文字改行調整**/
@media screen and (max-width: 338px) {
  .tooltip {
    width: 100%;
  }
}

/**firefox用のデザイン**/
@-moz-document url-prefix() {
  .tooltip {
    bottom: -84%;
  }
  .fixed-nav {
    margin-top: 82px;
  }
  /**注意書き文字改行調整**/
  @media screen and (max-width: 1493px) {
    .tooltip {
      bottom: -117%;
    }
  }
  /**注意書き文字改行調整**/
  @media screen and (max-width: 1013px) {
    .tooltip {
      bottom: -150%;
    }
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
  }
  /**注意書き文字改行調整**/
  @media screen and (max-width: 607px) {
    .tooltip {
      width: 60%;
    }
  }
  /**注意書き文字改行調整**/
  @media screen and (max-width: 506px) {
    .tooltip {
      width: 70%;
    }
  }
  /**注意書き文字改行調整**/
  @media screen and (max-width: 450px) {
    .tooltip {
      width: 90%;
    }
  }
}
</style>