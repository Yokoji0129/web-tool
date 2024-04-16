<script setup>
const props = defineProps({
  bookData: Object,
  selectedTextColor: String,
});

const emit = defineEmits(["update:selectedTextColor"]);

//テキストカラー選択肢
const textColors = [
  {
    id: "黒",
    color: "#000000",
  },
  {
    id: "赤",
    color: "red",
  },
  {
    id: "青",
    color: "blue",
  },
  {
    id: "緑",
    color: "green",
  },
  {
    id: "黄",
    color: "yellow",
  },
];

const bookTextColorSelect = () => {
  const selectedTextColor = props.bookData.bookTextColor;
  emit("update:selectedTextColor", selectedTextColor);
};
</script>

<template>
  <select
    v-model="bookData.bookTextColor"
    class="color-select"
    @change="bookTextColorSelect"
  >
    <option value="">テキスト色</option>
    <option
      v-for="(textColor, index) in textColors"
      :key="index"
      :value="textColor.color"
    >
      {{ textColor.id }}
    </option>
  </select>
</template>

<style scoped>
</style>