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

              <div class="col-md-6 ms-auto">
                        <label for="driver_id" class="form-label">Driver</label>
                        <select class="form-control" v-model="ride.driver_id">
                            <option v-for="dr in drivers" :key="dr.id" :value=dr.id>{{ dr.name }} </option>
                        </select>

                    </div>
                    <div class="col-md-6">
                <label for="place_available" class="form-label">place_available</label>
                <input type="text" class="form-control" id="place_available" v-model="ride.place_available">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="pickup_location" class="form-label">pickup_location</label>
                <input type="text" class="form-control" id="pickup_location" v-model="ride.pickup_location">
              </div>
              <div class="col-md-6">
                <label for="date" class="form-label">Date </label>
                <input type="date" class="form-control" id="date" v-model="ride.date">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="dropoff_location" class="form-label">dropoff_location</label>
                <input type="text" class="form-control" id="dropoff_location" v-model="ride.dropoff_location">
              </div>
              <div class="col-md-6">
                <label for="cost" class="form-label">cost</label>
                <input type="text" class="form-control" id="cost" v-model="ride.cost">
              </div>
            </div>
            
            <br />
            <button type="submit" class="btn btn-outline-primary" @click="addride">
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
  const ride = ref({
    driver_id: "",
    
    pickup_location: "",
    dropoff_location: "",
    date: "",
    cost: "",
    place_available: ""
  });
  
  const drivers = ref([]);
  const token = localStorage.getItem('token');


const getdrivers = () => {

    api.get('/api/drivers', { headers: { Authorization: `Bearer ${token}` } })
    .then(res => {
      drivers.value = res.data;
    }).catch(error => {
        if (error.response.status === 401) {
          // Rediriger vers la page de connexion ou prendre d'autres mesures
        } else {
          console.error('Erreur inattendue :', error);
        }
      });
  };
  onMounted(() => {
    getdrivers();
   
}
  );
  const addride = async () => {
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
      await Promise.all([
        api.get('/api/drivers', config)
        
      ]);
  
      await api.post("/api/rides/", ride.value , config);
      visible.value = false;
      window.location.reload();
    } catch (error) {
      console.error(error);
      // Handle error as needed
    }
  };
 
  const cancel = () => {
    visible.value = false;
  };
  
  </script>
  
  <style scoped></style>
  