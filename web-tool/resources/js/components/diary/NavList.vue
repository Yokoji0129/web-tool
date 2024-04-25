<script setup>
import { ref } from "vue";

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
</script>

<!--日記ページのnavlist-->
<template>
  <nav class="fixed-nav">
    <ul class="nav-list">
      <li class="nav-item-left">
        <p class="p" @click="toggleTooltip">日記ページ一覧</p>
      </li>
      <div class="tooltip" v-show="showTooltip">
        <fieldset>
          <h2>日記のタイトル</h2>
          <h3>目次</h3>
        </fieldset>
      </div>
      <li class="nav-item-center">
        <p class="p" @click="toggleTooltip2">本のタイトル</p>
      </li>
      <div class="tooltip2" v-show="showTooltip2">
        <fieldset>
          <p>選択してる日記のデザイン表示させるかも</p>
        </fieldset>
      </div>
      <li class="nav-item-right">
        <p class="p" @click="toggleTooltip3">ユーザー名:test</p>
      </li>
      <div class="tooltip3" v-show="showTooltip3">
        <fieldset>
          <button class="logout">ログアウト</button>
        </fieldset>
      </div>
    </ul>
  </nav>
</template>


<style scoped>
@media screen and (max-width: 1024px) {
  .tooltip,
  .tooltip2,
  .tooltip3 {
    width: 25%;
  }
}
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