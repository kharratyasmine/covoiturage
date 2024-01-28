<template>
    <div>
      <adddriver v-if="isAuthenticated" />
      <div class="card">
        <DataTable :value="drivers" stripedRows paginator :rows="5" :rowsPerPageOptions="[5, 10, 20, 50]" showGridlines dataKey="id" :loading="isLoading">
            <Column header="Image">
                <template #body="{ data }">
                    <img :src="data.image" :alt=data.reference class="shadow-4" width="65" />

                </template>
            </Column>
            <Column field="name" header="Nom" sortable></Column>
          <Column field="email" header="Email" sortable></Column>
          <Column field="phone" header="Telephone" sortable></Column>
          <Column field="birth_date" header="Date de naissance" sortable></Column>
          <Column field="id" header="Actions" style="min-width: 12rem">
            <template #body="val">
              <div class="d-flex">
                <editdriver :driver="val.data"/>
                <button type="button" class="btn btn-warning rounded-circle" @click="deleteDriver(val.data.id)">
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
import editdriver from './editdriver.vue';
import adddriver from './adddriver.vue';
const isAuthenticated = computed(() => {
  
  const token = localStorage.getItem('token');
  return !!token;
});
const drivers = ref([]);
const isLoading = ref(true);

const getDrivers = async () => {
   await api.get("/api/drivers", { headers: { Authorization: `Bearer ${token}` } })
  .then(response => {
    drivers.value = response.data;
    isLoading.value = false;
  }). catch(error => {
  if (error.response.status === 401) {
   
  } else {
    console.error('Erreur inattendue :', error);
  }
});
}
const token = localStorage.getItem('token');

const deleteDriver = async (id) => {

  if (!token) {
    // L'utilisateur n'est pas authentifié, rediriger vers la page de connexion ou afficher un message
    return;
  }

  if (window.confirm("Etes-vous sûr de vouloir supprimer ?")) {
    try {
      const response = await api.delete(`/api/drivers/${id}`, {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      
      getDrivers();
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
const handleDriverUpdated = () => {
  getDrivers();
};

onMounted(() => {
  if (isAuthenticated.value) {
  getDrivers();
}
});
</script>

<style scoped>
.drag {
  margin-top: 100px;
}
</style>
