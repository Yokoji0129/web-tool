<script setup>
import { useRoute } from "vue-router";
import { ref, onMounted, reactive } from "vue";
import BurgerMenu from "../components/diary/BurgerMenu.vue";
import PageOperation from "../components/diary/PageOperation.vue";
import PageMove from "../components/diary/PageMove.vue";
//スマホ用ページ操作表示フラグ
const showMenu = ref(false);
//ページ操作メニュー表示()スマホ専用
const toggleMenu = () => {
  if (window.innerWidth <= 1024) {
    showMenu.value = !showMenu.value;
  }
};
const loadingPage = ref(false);

const route = useRoute();
const diaryId = route.params.diaryId; //日記を開くときに渡される日記ID
const selectBookNumber = route.params.selectBookNumber; //日記を開くときに渡される日記index
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
      diary.value = response.data;
    })
    .catch((error) => {
      console.log(error);
    });
};

/**
 * やること
 * ページ移動したときに一番上を表示させる(タブレットやスマホサイズの時)
 * ページタイトルで改行できないようにする
 * リロードしたらdiaryIDが消えてしまうからページにいる間は消えないようにする
 * ページ追加場所を指定できるようにする
 *
 * **/

const pages = ref([]); //日記ページのデータを格納する配列
const currentPageIndex = ref(0); //現在表示しているページのindex
//ページの要素追加データ
const pageData = reactive({
  pageTitle: "",
  pageText1: "",
  pageText2: "",
});

//ページ追加用メソッド
const pageAdd = () => {
  loadingPage.value = true;
  //ページ追加用日記idはid,タイトルはtitle,テキストはtxt(今は1だけ)
  axios
    .post("/pageadd", {
      //日記ID
      id: diaryId,
      //タイトル文字色
      title_color: "",
      //ページタイトル
      title: "",
      //文章1
      txt: "",
      //文章2
      txt2: "",
      //マーカーの色
      marker_color: "",
      //文章の文字の色
      txt_color: "",
      //画像1の文章
      file_txt1: "",
      //画像2の文章
      file_txt2: "",
      //画像3の文章
      file_txt3: "",
      //画像4の文章
      file_txt4: "",
      //画像5の文章
      file_txt5: "",
      //画像6の文章
      file_txt6: "",
    })
    .then((response) => {
      alert(`${pages.value.length + 1}ページ目が追加されました`);
      displayPage();
    })
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {
      loadingPage.value = false;
    });
  showMenu.value = false;
};

//ページ表示メソッド
const displayPage = () => {
  axios
    .get(`/returnpage/${diaryId}`)
    .then((response) => {
      pages.value = response.data;
      if (pages.value.length === 0) {
        pageAdd(); //ページが空の場合(日記初回に開くとき)、新しいページを追加
      } else {
        currentPage();
      }
    })
    .catch((error) => {
      console.log(error);
    });
};

//ページ移動したときに表示内容変える
const currentPage = () => {
  //現在のページに合わせて現在のページのデータを取得
  const currentPage = pages.value[currentPageIndex.value][0];
  //取得したページのデータを表示用の変数に設定
  pageData.pageTitle = currentPage.page_title;
  pageData.pageText1 = currentPage.page_txt1;
  pageData.pageText2 = currentPage.page_txt2;
};

//ページ編集メソッド
const pageEdit = () => {
  loadingPage.value = true;
  //ここでページを編集して保存(このAPIではページ追加はできない)
  axios
    .post("/edit/page", {
      //ページID
      id: pages.value[currentPageIndex.value][0].page_id,
      //タイトル文字色
      title_color: "",
      //ページタイトル
      title: pageData.pageTitle,
      //文章1
      txt: pageData.pageText1,
      //文章2
      txt2: pageData.pageText2,
      //マーカーの色
      marker_color: "",
      //文章の文字の色
      txt_color: "",
      //画像1の文章
      file_txt1: "",
      //画像2の文章
      file_txt2: "",
      //画像3の文章
      file_txt3: "",
      //画像4の文章
      file_txt4: "",
      //画像5の文章
      file_txt5: "",
      //画像6の文章
      file_txt6: "",
    })
    .then((response) => {
      alert(`${currentPageIndex.value + 1}ページ目が保存されました`);
      toggleMenu();
      displayPage();
    })
    .catch((error) => {
      console.log(error);
    })
    .finally(() => {
      loadingPage.value = false;
    });
};

// ページ削除メソッド
const pageDelete = () => {
  if (window.confirm("このページを本当に削除しますか？")) {
    loadingPage.value = true;
    axios
      .post("/delete/page", {
        //ページID
        id: pages.value[currentPageIndex.value][0].page_id,
      })
      .then((response) => {
        alert(`${currentPageIndex.value + 1}ページ目が削除されました`);
        displayPage();
        toggleMenu();
      })
      .catch((error) => {
        console.log(error);
      })
      .finally(() => {
        loadingPage.value = false;
      });
  }
};

//ここから画像処理
//ファイル選択とアップロード
const selectedFile = ref(null);

const onFileSelected = (event) => {
  const file = event.target.files[0];
  if (file) {
    selectedFile.value = file;
  }
};

//画像アップロードめ
const uploadFile = () => {
  if (selectedFile.value) {
    const formData = new FormData();
    formData.append("file", selectedFile.value);

    axios
      .post("/file", formData, {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
      .then((response) => {
        console.log(response.data);
      })
      .catch((error) => {
        console.log(error);
      });
  } else {
    alert("ファイルを選択してください。");
  }
};

onMounted(() => {
  diaryInfo();
  displayPage();
});
</script>

<template>
  <BurgerMenu :diary="diary" :selectBookNumber="selectBookNumber" :pages="pages" :pageData="pageData"
    @update:currentPageIndex="currentPageIndex = $event" />
  <PageOperation :toggleMenu="toggleMenu" :pageAdd="pageAdd" :pageEdit="pageEdit" :pageDelete="pageDelete"
    :showMenu="showMenu" />
  <!--ここまでスマホ用ページ操作ボタン-->
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
        <textarea class="page-title" placeholder="ページタイトル" v-model="pageData.pageTitle"></textarea>
        <textarea class="page-text" placeholder="文章1" v-model="pageData.pageText1"></textarea>
        <textarea class="page-text" placeholder="文章2" v-model="pageData.pageText2"></textarea>
      </div>
    </div>
    <!--右側デザイン-->
    <div class="right-contents">
      <form @submit.prevent="uploadFile" enctype="multipart/form-data">
        <div class="file-box">
          <label>
            <input type="file" name="file" @change="onFileSelected" />写真を選択
          </label>
          <button type="submit">表示</button>
        </div>
      </form>
      <div class="image-box">
        <div class="image-container">
          <img class="delete-img" src="../../../public/icon/delete-img.png" />
          <img @click="togglePopup" class="image" src="../../../public/testImage/testImage.jpeg" />
        </div>
        <div class="image-container">
          <img class="delete-img" src="../../../public/icon/delete-img.png" />
          <img class="image" src="../../../public/testImage/test2.jpg" />
        </div>
        <div class="image-container">
          <img class="delete-img" src="../../../public/icon/delete-img.png" />
          <img class="image" src="../../../public/testImage/testImagetate.jpg" />
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
  <PageMove @update:currentPageIndex="currentPageIndex = $event" :currentPageIndex="currentPageIndex" :pages="pages"
    :currentPage="currentPage" />
  <!--ローディングアニメーション-->
  <div v-if="loadingPage" class="loading-overlay">
    <div class="spinner"></div>
  </div>
</template>

<style scoped>
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
    height: 6vh;
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
@media screen and (max-width: 1300px) {
  .page-title {
    margin-top: 0;
  }
  .page-text {
    height: 17vh;
  }
}

@media screen and (max-width: 1024px) {
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
}

/*スマホ(480px以下)*/
@media only screen and (max-width: 480px) {
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

@-moz-document url-prefix() {}
</style>
