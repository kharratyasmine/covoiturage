<template>
    <div>
      <addreservation v-if="isAuthenticated"/>
      <div class="card">
        <DataTable :value="reservations" stripedRows paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" showGridlines dataKey="id" :loading="isLoading">
          <Column field="client.name" header="client" sortable></Column>
          <Column field="ride.dropoff_location" header="ride" sortable></Column>
          <Column field="id" header="Actions" style="min-width: 12rem">
            <template #body="val">
              <div class="d-flex">
                <editreservation :reservation="val.data"/>
                <button type="button" class="btn btn-warning rounded-circle" @click="deletereservation(val.data.id)">
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
import { ref, onMounted , computed}  from 'vue';
import editreservation from './editreservation.vue';
import addreservation from './addreservation.vue';
const isAuthenticated = computed(() => {
  
  const token = localStorage.getItem('token');
  return !!token;
});
const reservations = ref([]);
const isLoading = ref(true);

const getreservations = async () => {

   await api.get("/api/reservations", { headers: { Authorization: `Bearer ${token}` } })
  .then(response => {
    reservations.value = response.data;
    isLoading.value = false;
  }). catch(error => {
  if (error.response.status === 401) {
   
  } else {
    console.error('Erreur inattendue :', error);
  }
});
}
const token = localStorage.getItem('token');

const deletereservation = async (id) => {
  if (!token) {
    // L'utilisateur n'est pas authentifié, rediriger vers la page de connexion ou afficher un message
    return;
  }

  if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
    try {
      const response = await api.delete(`/api/reservations/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      
      getreservations();
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
const handlereservationUpdated = () => {
  getreservations();
};

onMounted(() => {
  if (isAuthenticated.value) {
  getreservations();
  }
});
</script>

  
  <style scoped>
  .drag {
    margin-top: 100px;
  }
  </style>
  