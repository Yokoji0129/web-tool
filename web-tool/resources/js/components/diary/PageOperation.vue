<script setup>
import { ref } from "vue";
const props = defineProps({
  toggleMenu: Function,
  pageAdd: Function,
  pageEdit: Function,
  pageDelete: Function,
  showMenu: Boolean,
  pages: Array,
  currentPageIndex: Number,
  loadingPage: Object,
  displayPage: Function,
});
const emit = defineEmits(["update:loadingPage"]);
//ページ操作テキストの表示フラグ(編集、削除、追加)
const showEdit = ref(false);
const showDelete = ref(false);
const showAdd = ref(false);
const showQuestion = ref(false);

//スマホ用ページ操作表示フラグ
const showMenu = ref(false);
//ページ操作メニュー表示()スマホ専用
const toggleMenu = () => {
  if (window.innerWidth <= 1024) {
    showMenu.value = !showMenu.value;
  }
};

//ページ削除メソッド
const pageDelete = async () => {
  if (window.confirm("このページを本当に削除しますか？")) {
    emit("update:loadingPage", true);

    try {
      await axios.post("/delete/page", {
        // ページID
        id: props.pages[props.currentPageIndex][0].page_id,
      });

      alert(`${props.currentPageIndex + 1}ページ目が削除されました`);
      props.displayPage();
      toggleMenu();
    } catch (error) {
      console.log(error);
    } finally {
      emit("update:loadingPage", false);
    }
  }
};
</script>

<template>
  <div class="page-operation-btn">
    <!--編集ボタン-->
    <div
      class="btn"
      @click="pageEdit"
      @mouseover="showEdit = true"
      @mouseleave="showEdit = false"
    >
      <img src="../../../../public/icon/edit-page.png" alt="" />
      <span class="edit-text" v-if="showEdit">保存</span>
    </div>
    <!--削除ボタン-->
    <div
      class="btn"
      @click="pageDelete"
      @mouseover="showDelete = true"
      @mouseleave="showDelete = false"
    >
      <img src="../../../../public/icon/delete-page.png" alt="" />
      <span class="delete-text" v-if="showDelete">削除</span>
    </div>
    <!--追加ボタン-->
    <div
      class="btn"
      @click="pageAdd"
      @mouseover="showAdd = true"
      @mouseleave="showAdd = false"
    >
      <img src="../../../../public/icon/add-page.png" alt="" />
      <span class="add-text" v-if="showAdd">追加</span>
    </div>
    <!--使い方表示ボタン-->
    <div
      class="btn"
      @mouseover="showQuestion = true"
      @mouseleave="showQuestion = false"
    >
      <img src="../../../../public/icon/hatena.png" alt="" />
      <span class="question-text" v-if="showQuestion">手順</span>
    </div>
  </div>

  <!--スマホ用ページ操作ボタン-->
  <div class="page-operation-hamburger">
    <img
      src="../../../../public/icon/hamburger-note.png"
      alt=""
      @click="toggleMenu"
    />
  </div>
  <div class="menu" :class="{ visible: showMenu }" v-show="showMenu">
    <div class="page-operation-btn-sp">
      <!--編集ボタン-->
      <div class="btn-sp" @click="pageEdit">
        <img src="../../../../public/icon/edit-page.png" alt="" />
        <p>ページ保存</p>
      </div>
      <!--削除ボタン-->
      <div class="btn-sp" @click="pageDelete">
        <img src="../../../../public/icon/delete-page.png" alt="" />
        <p>ページ削除</p>
      </div>
      <!--追加ボタン-->
      <div class="btn-sp" @click="pageAdd">
        <img src="../../../../public/icon/add-page.png" alt="" />
        <p>ページ追加</p>
      </div>
      <div class="btn-sp">
        <img src="../../../../public/icon/hatena.png" alt="" />
        <p>使い方</p>
      </div>
    </div>
  </div>
</template>

<style scoped>
menu {
  display: none;
}

.menu.visible {
  display: block;
}

.page-operation-btn {
  display: flex;
  position: fixed;
  right: 10px;
  top: 10px;
  z-index: 100;
}

.page-operation-btn img {
  cursor: pointer;
  margin: 0 5px;
  width: 60px;
}

.edit-text,
.delete-text,
.add-text,
.question-text {
  text-align: center;
  background-color: #f8f9fa;
  font-size: 24px;
  margin-top: 4px;
  border-left: 3px solid #ced4da;
  border-right: 3px solid #ced4da;
  border-bottom: 3px solid #ced4da;
}

.btn:hover .edit-text {
  display: block;
}

.btn:hover .delete-text {
  display: block;
}

.btn:hover .add-text {
  display: block;
}

.btn:hover .question-text {
  display: block;
}

.page-operation-hamburger {
  display: none;
  position: fixed;
  right: 10px;
  top: 10px;
  z-index: 100;
  cursor: pointer;
}

.page-operation-hamburger img {
  width: 60px;
}

.page-operation-btn-sp {
  background-color: #ccc;
  display: block;
  position: fixed;
  right: 0px;
  top: 82px;
  z-index: 100;
}

.page-operation-btn-sp img {
  padding: 15px 0 0 0;
  width: 60px;
}

.btn-sp {
  text-align: center;
}

.btn-sp p {
  background-color: #ced4da;
  font-weight: bold;
  margin: 0;
  padding: 0 5px;
}

@media screen and (max-width: 1024px) {
  .page-operation-btn {
    display: none;
  }

  .page-operation-hamburger {
    display: block;
  }
}

/*タブレット(768px以下)*/
@media screen and (max-width: 768px) {
  .page-operation-hamburger {
    right: -3px;
    top: 1px;
  }

  .page-operation-btn-sp {
    right: 0px;
    top: 62px;
  }

  .page-operation-btn {
    top: 7px;
  }

  .page-operation-btn img {
    width: 50px;
  }
}

@-moz-document url-prefix() {
  .page-operation-btn {
    right: 5px;
    top: 5px;
  }

  .edit-text,
  .delete-text,
  .add-text,
  .question-text {
    margin-top: 2px;
  }

  @media screen and (max-width: 768px) {
    .page-operation-btn-sp {
      right: 0px;
      top: 61px;
    }
  }
}
</style>