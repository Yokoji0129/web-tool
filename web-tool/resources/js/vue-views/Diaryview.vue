<script setup>
import { useRoute } from 'vue-router';
import { ref, onMounted, reactive } from "vue";
import BurgerMenu from "../components/diary/BurgerMenu.vue";
const route = useRoute();
const diaryId = route.params.diaryId;//日記を開くときに渡される日記ID
const selectBookNumber = route.params.selectBookNumber;
const showPopup = ref(false); //ポップアップの表示制御フラグ

//ポップアップの表示非表示
const togglePopup = () => {
  showPopup.value = !showPopup.value;
};

//日記の全情報入れる
const diary = ref([]);
const diaryInfo = () => {
  axios
    .get("returndiary")
    .then((response) => {
      console.log(response.data);
      diary.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

//ページ内容リスト
const pageContentsList = ref([]);
const pageData = reactive({
  pageTitle: "",
  pageText1: "",
  pageText2: "",
});
const pageAdd = () => {
  //ページ追加用日記idはid,タイトルはtitle,テキストはtxt(今は1だけ)
  axios
    .post("/pageadd", {
      id: diaryId,
      title: pageData.pageTitle,
      txt: pageData.pageText1,
    })
    .then((response) => {})
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {});
};

//ページ保存
const pageKeep = () => {
  axios
    .post("/edit/page", {})
    .then((response) => {})
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {});
};

onMounted(() => {
  diaryInfo();
});
</script>

<template>
  <BurgerMenu :diary="diary" :selectBookNumber="selectBookNumber" />
  <div class="diaryKeep-btn">
    <button>ページ保存</button>
  </div>
  <div class="flex-box">
    <!--左側デザイン-->
    <div class="left-contents">
      <div class="fuction-box">
        <select class="color-select">
          <option value="">マーカー</option>
          <option value="">マーカー 赤</option>
          <option value="">マーカー 青</option>
          <option value="">マーカー 緑</option>
        </select>
        <select class="color-select">
          <option value="">文字色</option>
          <option value="">文字色 赤</option>
          <option value="">文字色 青</option>
          <option value="">文字色 緑</option>
        </select>
      </div>
      <div class="text-area">
        <textarea
          class="page-title"
          placeholder="ページタイトル"
          v-model="pageData.pageTitle"
        ></textarea>
        <textarea
          class="page-text"
          placeholder="文章1"
          v-model="pageData.pageText1"
        ></textarea>
        <textarea
          class="page-text"
          placeholder="文章2"
          v-model="pageData.pageText2"
        ></textarea>
      </div>
    </div>
    <!--右側デザイン-->
    <div class="right-contents">
      <div class="file-box">
        <label> <input type="file" name="file" />写真を選択 </label>
      </div>
      <div class="image-box">
        <div class="image-container">
          <img class="delete-img" src="../../../public/icon/delete-img.png" />
          <img
            @click="togglePopup"
            class="image"
            src="../../../public/testImage/testImage.jpeg"
          />
        </div>
        <div class="image-container">
          <img class="delete-img" src="../../../public/icon/delete-img.png" />
          <img class="image" src="../../../public/testImage/test2.jpg" />
        </div>
        <div class="image-container">
          <img class="delete-img" src="../../../public/icon/delete-img.png" />
          <img
            class="image"
            src="../../../public/testImage/testImagetate.jpg"
          />
        </div>
      </div>
    </div>
  </div>

  <!--ポップアップ-->
  <div v-if="showPopup" class="popup">
    <div class="popup-content-img">
      <button class="btn-close" @click="togglePopup">閉じる</button>
      <div class="popup-img">
        <img src="../../../public/testImage/testImage.jpeg" />
      </div>
      <div class="image-text">
        <textarea placeholder="コメント"></textarea>
      </div>
      <div class="keepImgText-btn">
        <button>保存</button>
      </div>
    </div>
  </div>
  <!--ページ遷移-->
  <div class="page-transition">
    <button class="back-page">前のページ</button>
    <p class="page-count">0</p>
    <button class="next-page">次のページ</button>
  </div>
</template>

<style scoped>
.diaryKeep-btn {
  position: fixed;
  right: 10px;
  top: 10px;
  z-index: 100;
}
.diaryKeep-btn button {
  padding: 20px 60px;
  font-size: 16px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.flex-box {
  display: flex;
  padding: 82px 0 0 0;
  height: 90vh;
}

.left-contents {
  width: 50%;
  background-color: rgba(74, 73, 73, 0.5);
}

.text-area {
  text-align: center;
}

.page-title {
  margin-top: 10px;
  text-align: center;
  font-size: 24px;
  width: 95%;
  padding-top: 20px;
  resize: none;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.page-title:hover {
  border-color: #9aa0a7;
}

.page-text {
  margin-top: 20px;
  width: 93%;
  height: 32vh;
  font-size: 24px;
  line-height: 1.5;
  resize: none;
  padding: 10px;
  border: 1px solid #ced4da;
  border-radius: 5px;
}

.page-text:hover {
  border-color: #9aa0a7;
}

.left-contents textarea::selection {
  background-color: yellow;
  color: red;
}

.fuction-box {
  display: flex;
}

select {
  width: 100%;
  height: 50px;
  cursor: pointer;
}

.right-contents {
  width: 50%;
  background-color: rgba(74, 73, 73, 0.5);
}

.file-box {
  margin: 12px 0;
}

label {
  padding: 12px 40% 13px 10px;
  font-size: 14px;
  border: 2px solid #ccc;
  background-color: #ffffff;
  cursor: pointer;
  transition: 0.3s;
}

label:hover {
  color: #007bff;
  border-color: #007bff;
}

input[type="file"] {
  display: none;
}

.image-box {
  overflow: auto;
  text-align: center;
  height: 78vh;
}

.image {
  margin: 30px auto;
  max-width: 100%;
  height: auto;
  display: block;
}
.image-container {
  position: relative;
  display: inline-block;
}

.delete-img {
  cursor: pointer;
  position: absolute;
  top: 35px;
  right: 0;
  width: 50px;
}

.page-transition {
  display: flex;
  position: fixed;
  width: 100%;
  bottom: 46px;
  justify-content: center;
  align-items: center;
  background-color: #5a646d;
}

.popup-content-img {
  position: relative;
  width: auto;
  height: auto;
  background-color: #ffffff;
  padding: 20px;
  border-radius: 5px;
  border: 3px solid #ced4da;
  box-shadow: 7px 7px 4px rgba(0, 0, 0, 0.5);
  overflow-y: auto;
  /*スクロール可能*/
}

.popup-img img {
  max-width: 100%;
  margin: 20px 0 0 0;
}

.image-text textarea {
  padding: 5px;
  width: 97%;
  height: 60px;
  font-size: 20px;
  resize: none;
}

.keepImgText-btn {
  text-align: center;
}
.keepImgText-btn button {
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.back-page,
.next-page {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
  border: none;
  transition: background-color 0.3s ease;
}

.back-page:hover,
.next-page:hover {
  background-color: #0056b3;
}

.page-count {
  padding: 3px 10px;
  border-radius: 50%;
  margin: 15px 10px;
  background-color: #ffffff;
}

/**デスクトップのtextarea調整**/
@media screen and (max-width: 1980px) {
  .page-text {
    height: 25vh;
  }

  .image-box {
    height: 72vh;
  }
}

/**ノートパソコンのtextarea調整**/
@media screen and (max-width: 1600px) {
  .flex-box {
    height: 80vh;
  }

  .page-title {
    margin-top: 0;
  }

  .page-text {
    height: 22vh;
    margin-top: 10px;
  }

  .image-box {
    height: 70vh;
  }
}

@media screen and (max-width: 1024px) {
  .diaryKeep-btn {
    right: 15px;
    top: 15px;
  }
  .diaryKeep-btn button {
    padding: 15px 50px;
  }
  .flex-box {
    flex-direction: column;
  }

  .color-select {
    margin-bottom: 8px;
  }

  .left-contents {
    width: 100%;
  }

  .right-contents {
    width: 100%;
  }

  .page-title {
    margin-top: 10px;
  }

  .page-transition {
    bottom: 35px;
  }
  .image-box {
    margin-bottom: 100px;
  }
  .popup-content-img {
    padding: 10px;
  }

  .popup-img img {
    margin: 10px 0 0 0;
  }
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
  .flex-box {
    margin: -21px 0;
    flex-direction: column;
  }
  .diaryKeep-btn {
    right: 10px;
    top: 10px;
  }
  .diaryKeep-btn button {
    padding: 10px 30px;
  }
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 480px) {
  .diaryKeep-btn button {
    padding: 10px 10px;
  }
  .page-title {
    margin: 0;
    font-size: 18px;
  }

  .page-text {
    margin-top: 5px;
    font-size: 14px;
    width: 90%;
  }

  .image {
    margin: 15px auto;
  }

  .delete-img {
    top: 20px;
  }
}

@-moz-document url-prefix() {
}
</style>
