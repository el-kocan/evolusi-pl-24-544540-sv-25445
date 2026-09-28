<script setup>
import { onMounted, ref } from 'vue';

const tasks = ref([]);
const loading = ref(true);
const error = ref('');
const apiUrl = import.meta.env.VITE_API_URL;

async function loadTasks() {
  loading.value = true;
  error.value = '';

  try {
    const response = await fetch(`${apiUrl}/tugas`);
    if (!response.ok) {
      throw new Error(`API gagal merespons (${response.status})`);
    }
    const payload = await response.json();
    tasks.value = payload.data;
  } catch (exception) {
    error.value = exception.message;
  } finally {
    loading.value = false;
  }
}

onMounted(loadTasks);
</script>

<template>
  <section class="hero">
    <p class="eyebrow">
      Vue 3 + Laravel API
    </p>
    <h1>Daftar Tugas</h1>
    <p>
      Data berikut dimuat dari endpoint JSON Laravel.
    </p>
  </section>

  <p
    v-if="loading"
    class="status"
  >
    Memuat tugas...
  </p>
  <p
    v-else-if="error"
    class="status error"
  >
    {{ error }}
  </p>
  <div
    v-else
    class="task-list"
  >
    <article
      v-for="task in tasks"
      :key="task.id"
      class="task-card"
    >
      <div>
        <h2>{{ task.title }}</h2>
        <p>{{ task.description || 'Tidak ada deskripsi.' }}</p>
      </div>
      <span :class="['badge', task.is_completed ? 'done' : 'pending']">
        {{ task.is_completed ? 'Selesai' : 'Belum selesai' }}
      </span>
    </article>
    <p
      v-if="tasks.length === 0"
      class="status"
    >
      Belum ada tugas.
    </p>
  </div>
</template>
