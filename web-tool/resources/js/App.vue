<template>
  <header class="header">
    <h1 class="header-title">旅行日記</h1>
  </header>
  <RouterView />
</template>

<style scoped>
.header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #ced4da;
  padding: 20px;
  text-align: center;
}

.header-title {
  margin: 0;
  font-size: 2rem;
  font-family: "Georgia", serif;
  color: #495057;
}

/*ウィンドウ幅が750px以下の場合*/
@media screen and (max-width: 750px) {
  .header {
    padding: 10px;
  }
}
</style>

