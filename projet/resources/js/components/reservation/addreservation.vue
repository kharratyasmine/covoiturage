<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
      <div class="container-fluid">
        <button type="button" class="btn btn-warning rounded-circle" @click="visible = true">
          <span style="color: rgb(43, 27, 27)">
            <i class="fa-solid fa-square-plus"></i>
          </span>
          New
        </button>
      </div>
    </nav>
  
    <form>
      <div class="card flex justify-content-center">
        <Dialog v-model:visible="visible">
          <div class="card flex justify-content-center">
            <div class="row">
    
              <div class="col-md-6 ">
                        <label for="client_id" class="form-label">client_id</label>
                        <select class="form-control" v-model="reservation.client_id">
                            <option v-for="cli in clients" :key="cli.id" :value=cli.id>{{ cli.name }} </option>
                        </select>

                    </div>

              <div class="col-md-6 ">
                        <label for="ride_id" class="form-label">ride_id</label>
                        <select class="form-control" v-model="reservation.ride_id">
                            <option v-for="rid in rides" :key="rid.id" :value=rid.id>{{ rid.dropoff_location }} </option>
                        </select>

                    </div>



            </div>
            <br />
            <button type="submit" class="btn btn-outline-primary" @click="addreservation">
              <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
            <button type="button" class="btn btn-outline-primary" @click="cancel">
              <i class="fa-solid fa-floppy-disk"></i> Annuler
            </button>
          </div>
        </Dialog>
      </div>
    </form>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import api from "../config/api.js";
  import Dialog from "primevue/dialog";
  
  const visible = ref(false);
  const reservation = ref({
    client_id: "",
    ride_id: "",
  });
  
  const clients = ref([]);
  const rides = ref([]);
  const token = localStorage.getItem('token');
  
  const getclients = async () => {
    await api.get("/api/clients", { headers: { Authorization: `Bearer ${token}` } })
      .then(response => {
        clients.value = response.data;
      })
      .catch(error => {
        if (error.response.status === 401) {
          // Rediriger vers la page de connexion ou prendre d'autres mesures
        } else {
          console.error('Erreur inattendue :', error);
        }
      });
  };
  
  const getrides = async () => {
    await api.get('/api/rides', { headers: { Authorization: `Bearer ${token}` } })
      .then(response => {
        rides.value = response.data;
      })
      .catch(error => {
        if (error.response.status === 401) {
          // Rediriger vers la page de connexion ou prendre d'autres mesures
        } else {
          console.error('Erreur inattendue :', error);
        }
      });
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
  
  onMounted(() => {
    getclients();
    getrides();
  });
  
  const addreservation = async () => {
    const token = localStorage.getItem('token');
  
    if (!token) {
      console.error("User is not authenticated");
      return;
    }
  
    const config = {
      headers: {
        Authorization: `Bearer ${token}`
      }
    };
  
    try {
      // Avant d'ajouter la réservation, assurez-vous que les clients et les trajets existent
      await Promise.all([
        api.get('/api/clients', config),
        api.get('/api/rides', config)
      ]);
  
      // Ajoutez la réservation
      await api.post("/api/reservations/", reservation.value, config);
      visible.value = false;
      window.location.reload();
    } catch (error) {
      console.error("Error adding reservation:", error);
    }
  };
  
  const cancel = () => {
    visible.value = false;
  };
  </script>
  
  
  <style scoped></style>
  