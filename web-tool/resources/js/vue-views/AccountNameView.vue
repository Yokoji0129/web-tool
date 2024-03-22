<template>
  <div class="account-name-box">
    <h2>アカウント名作成</h2>
    <form>
      <input type="text" placeholder="アカウント名" />
      <!--まだどこに飛ぶか決めてない-->
      <button class="decision">決定</button>
    </form>
  </div>
</template>
  
<style scoped>
.account-name-box {
  width: 700px;
  margin: 300px auto;
  padding: 20px;
  background-color: #f2e6d9;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.account-name-box h2 {
  text-align: center;
  margin-bottom: 20px;
}

.account-name-box input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 2px solid #594736;
  border-radius: 5px;
  box-sizing: border-box;
  background-color: #e4d6c8;
}

.decision{
  text-align: center;
  width: 100%;
  padding: 10px;
  border: none;
  background-color: #8b5a2b;
  color: #fff;
  border-radius: 5px;
  cursor: pointer;
}

.decision:hover{
  background-color: #54391e;
}

/*ウィンドウ幅が700px以下の場合*/
@media screen and (max-width: 700px) {
  .account-name-box {
    width: 300px;
    margin: 100px auto;
    margin-top: 200px;
  }
  .signup-link {
    width: 93%;
  }
}
</style>