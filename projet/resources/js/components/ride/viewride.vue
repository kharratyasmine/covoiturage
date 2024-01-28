<template>
    <div>
      <addride v-if="isAuthenticated"/>
      <div class="card">
        <DataTable :value="rides" stripedRows paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" showGridlines dataKey="id" :loading="isLoading">
          <Column field="driver.name" header="name" sortable></Column>
          
          <Column field="pickup_location" header="pickup_location" sortable></Column>
          <Column field="dropoff_location" header="dropoff_location" sortable></Column>
          <Column field="date" header="date" sortable></Column>
          <Column field="cost" header="cost" sortable></Column>
          <Column field="place_available" header="place_available" sortable></Column>
          <Column field="id" header="Actions" style="min-width: 12rem">
            <template #body="val">
              <div class="d-flex">
                <editride :ride="val.data"/>
                <button type="button" class="btn btn-warning rounded-circle" @click="deleterides(val.data.id)">
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
  import { ref, onMounted , computed} from 'vue';
  import editride from './editride.vue';
  import addride from './addride.vue';
  const isAuthenticated = computed(() => {
  
  const token = localStorage.getItem('token');
  return !!token;
});
  const rides = ref([]);
  const isLoading = ref(true);
  
  const getrides = async () => {
    await api.get("/api/rides", { headers: { Authorization: `Bearer ${token}` } })
  .then(response => {
      rides.value = response.data;
      isLoading.value = false;
    }). catch(error => {
  if (error.response.status === 401) {
   
  } else {
    console.error('Erreur inattendue :', error);
  }
});
}
const token = localStorage.getItem('token');
  const deleterides = async (id) => {
  
if (!token) {
  // Gérer l'absence d'authentification, par exemple, rediriger vers la page de connexion
  console.error("User is not authenticated");
  return;
}
if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
  try {
    const response =  await api.delete(`/api/rides/${id}`, {
  headers: {
    Authorization: `Bearer ${token}`
  }
});
        getrides();
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
  
  const handlerideUpdated = () => {
    getrides();
  };
  
  onMounted(() => {
    if (isAuthenticated.value) {
    getrides();
    }
  });
  </script>
  
  <style scoped>
  .drag {
    margin-top: 100px;
  }
  </style>
  