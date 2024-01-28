<template>
  <div>
    <addvehicle v-if="isAuthenticated" />
    <div class="card">
      <DataTable :value="vehicles" stripedRows paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" showGridlines
        dataKey="id" :loading="isLoading">
        <Column header="Image">
          <template #body="{ data }">
            <img :src="data.image" :alt=data.reference class="shadow-4" width="65" />

          </template>
        </Column>
        <Column field="model" header="Model" sortable></Column>
        <Column field="matricule" header="Matricule" sortable></Column>
        <Column field="driver.name" header="driver name" sortable></Column>
        <Column field="id" header="Actions" style="min-width: 12rem">
          <template #body="val">
            <div class="d-flex">
              <editvehicle :vehicle="val.data" />
              <button type="button" class="btn btn-warning rounded-circle" @click="deletevehicle(val.data.id)">
                <span style="color: rgb(245, 5, 5)">
                  <i class="fa-solid fa-trash"></i>
                </span>
              </button>
            </div>
          </template>
        </Column>
      </DataTable>
    </div>
  </div>
</template>
<script setup>
import api from '../config/api';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import { ref, onMounted, computed } from 'vue';
import editvehicle from './editvehicle.vue';
import addvehicle from './addvehicle.vue';
const isAuthenticated = computed(() => {

  const token = localStorage.getItem('token');
  return !!token;
});

const vehicles = ref([]);
const isLoading = ref(true);

const getvehicles = async () => {
  await api.get("/api/vehicles", { headers: { Authorization: `Bearer ${token}` } })
    .then(response => {
      vehicles.value = response.data;
      isLoading.value = false;
    }).catch(error => {
      if (error.response.status === 401) {

      } else {
        console.error('Erreur inattendue :', error);
      }
    });
}


const token = localStorage.getItem('token');
const deletevehicle = async (id) => {

  if (!token) {

    console.error("User is not authenticated");
    return;
  }

  if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
    try {
      const response = await api.delete(`/api/vehicles/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      getvehicles();
    } catch (error) {
      console.error(error);
    }
  }
};
const authenticateUser = async (credentials) => {
  try {
    const response = await api.post('/api/login', credentials);
    const token = response.data.token;

    localStorage.setItem('token', token);

    router.push('/home');
  } catch (error) {
    console.error(error);
  }
};

const handlevehiclesUpdated = () => {
  getvehicles();
};

onMounted(() => {
  if (isAuthenticated.value) {
    getvehicles();
  }
});
</script>

<style scoped>
.drag {
  margin-top: 100px;
}
</style>
