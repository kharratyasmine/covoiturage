<template>
    <button type="button" class="btn btn-warning rounded-circle " @click="visible = true">
        <span style="color: rgb(233, 240, 241)">
            <i class="fa-solid fa-pen-to-square"></i>

        </span>

    </button>
    <form>
        <div class="card flex justify-content-center">
            <Dialog v-model:visible="visible">
                <div class="row">
              
                    <div class="col-md-6 ms-auto">
                        <label for="driver_id" class="form-label">Nom driver</label>
                        <select class="form-control" v-model="ride.driver_id">
                            <option v-for="sc in drivers" :key="sc.id" :value=sc.id>{{ sc.name }}</option>
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
                        <label for="dropoff_location" class="form-label">dropoff_location</label>
                        <input type="text" class="form-control" id="dropoff_location" v-model="ride.dropoff_location">
                    </div>
              
            </div>
            <div class="row">
                    <div class="col-md-6">
                        <label for="cost" class="form-label">cost</label>
                        <input type="text" class="form-control" id="cost" v-model="ride.cost">

                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">date</label>
                        <input type="date" class="form-control" id="date" v-model="ride.date">
                    </div>
                </div>

               
                <br />
                <button type="submit" className="btn btn-outline-primary" @click="modifierride">
                    <i class="fa-solid fa-floppy-disk"></i>Enregister
                </button>
                <button type="button" className="btn btn-outline-primary" @click="cancel">
                    <i class="fa-solid fa-floppy-disk"></i>cancel
                </button>
            </Dialog>
        </div>
    </form>
</template>

<script setup>
import api from '../config/api.js';
import { ref, onMounted } from "vue"
import Dialog from 'primevue/dialog';
const props=defineProps(['ride'])

const visible = ref(false);
const ride = ref({})

const drivers = ref([]);


const getdriver_id = async () => {
    const token = localStorage.getItem('token');
    if (!token) {
    // Gérer l'absence d'authentification, par exemple, rediriger vers la page de connexion
    console.error("User is not authenticated");
    return;
  }

  const config = {
    headers: {
      Authorization: `Bearer ${token}`
    }
  };

  try {
    const response = await api.get('/api/drivers', config);
    drivers.value = response.data;
} catch(error) {
    console.log(error)
}
}


const loadride = () => {
ride.value = props.ride
}
onMounted(() => {
    
    getdriver_id()
    loadride()
}
);

const modifierride = () => {
    const token = localStorage.getItem('token');

if (!token) {
  // Gérer l'absence d'authentification, par exemple, rediriger vers la page de connexion
  console.error("User is not authenticated");
  return;
}

const config = {
  headers: {
    Authorization: `Bearer ${token}`
  }
};

try {
    api.put(`/api/rides/${ride.value.id}`, ride.value, config);
       visible.value = false
        } catch(error) {
            console.error("There was an error!", error);
        }
}

const cancel = () => {
    visible.value = false

}

</script>
<style scoped></style>