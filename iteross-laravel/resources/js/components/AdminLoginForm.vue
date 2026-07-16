<script setup>
import { computed } from 'vue';
import { useAuthFormStore } from '@/stores/authFormStore';

const props = defineProps({
    action: { type: String, required: true },
    csrf: { type: String, required: true },
    errors: { type: Object, default: () => ({}) },
});

const store = useAuthFormStore();
const emailError = computed(() => props.errors.email?.[0] || '');
</script>

<template>
  <form :action="action" method="POST">
    <input type="hidden" name="_token" :value="csrf">

    <div class="field">
      <label>ПОЧТА</label>
      <input v-model="store.email" required type="email" name="email" placeholder="admin@iteross.ru">
    </div>

    <div class="field" style="margin-bottom: 28px;">
      <label>ПАРОЛЬ</label>
      <input v-model="store.password" required type="password" name="password" placeholder="••••••••">
    </div>

    <div v-if="emailError" class="error-box">{{ emailError }}</div>

    <button type="submit" class="button-primary">Войти</button>
  </form>
</template>
