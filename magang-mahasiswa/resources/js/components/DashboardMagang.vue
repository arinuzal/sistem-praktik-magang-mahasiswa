<template>
  <div class="text-white">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold">Mahasiswa Magang di PT Sinar Jaya</h2>
      <div class="flex gap-2">
        <select v-model="filterStatus" class="border p-2 rounded text-black">
          <option value="">Semua</option>
          <option value="sedang magang">Sedang Magang</option>
          <option value="belum magang">Belum Magang</option>
        </select>
        <input type="text" v-model="search" class="border p-2 rounded text-black" placeholder="Cari nama/nim">
        <button class="bg-blue-500 px-4 py-2 rounded" @click="cari">Cari</button>
      </div>
    </div>

    <div class="overflow-x-auto rounded bg-gray-800 p-4">
      <table class="table-auto w-full text-left">
        <thead>
          <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Semester</th>
            <th>Mata Kuliah</th>
            <th>Status</th>
            <th>Nilai</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="mhs in filteredData" :key="mhs.nim">
            <td>{{ mhs.nama }}</td>
            <td>{{ mhs.nim }}</td>
            <td>{{ mhs.semester }}</td>
            <td>
              <ul>
                <li v-for="mk in mhs.mata_kuliah">{{ mk }}</li>
              </ul>
            </td>
            <td>{{ mhs.status }}</td>
            <td>{{ mhs.nilai ?? '-' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

// dummy data, nanti ganti dari props/axios
const data = ref([
  {
    nama: 'rama',
    nim: '12345678',
    semester: 'genap',
    mata_kuliah: ['TPK', 'TPUU', 'Arbitrase dan APS', 'Teknik Pengurusan Perizinan'],
    status: 'belum magang',
    nilai: null
  }
])

const filterStatus = ref('')
const search = ref('')

const filteredData = computed(() => {
  return data.value.filter(mhs => {
    const cocokStatus = filterStatus.value ? mhs.status === filterStatus.value : true
    const cocokCari = search.value
      ? mhs.nama.toLowerCase().includes(search.value.toLowerCase()) || mhs.nim.includes(search.value)
      : true
    return cocokStatus && cocokCari
  })
})

const cari = () => {
}
</script>

<style scoped>
table th,
table td {
  padding: 8px;
  border-bottom: 1px solid #444;
}
</style>
