<template>
    <button type="button" class="btn btn-warning rounded-circle " @click="visible = true">
        <span style="color: rgb(233, 240, 241)">
            <i class="fa-solid fa-pen-to-square"></i>

        </span>

    </button>
    <form class="d-flex">
        <div class="card flex justify-content-center">
            <Dialog v-model:visible="visible">
                <div class="row">
    
                    <div class="col-md-6 ms-auto">
                        <label for="client_id" class="form-label"> client</label>
                        <select class="form-control" v-model="reservation.client_id">
                            <option v-for="cli in clients" :key="cli.id" :value=cli.id>{{ cli.name }}</option>
                        </select>

                    </div>

                    <div class="col-md-6 ms-auto">
                        <label for="ride_id" class="form-label">ride</label>
                        <select class="form-control" v-model="reservation.ride_id">
                            <option v-for="rid in rides" :key="rid.id" :value=rid.id>{{ rid.dropoff_location }}</option>
                        </select>

                    </div>

                </div>
                <br />
                <button type="submit" className="btn btn-outline-primary" @click="modifierreservation">
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
const props = defineProps(['reservation'])

const visible = ref(false);
const reservation = ref({})
const clients = ref([]);
const rides = ref([]);

const getclients = async () => {
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
    const response = await api.get("/api/clients", config);
    clients.value = response.data;
  } catch (error) {
    console.log(error);
  }
}

const getrides = async () => {
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
    const response = await api.get('/api/rides', config);
    rides.value = response.data;
  } catch (error) {
    console.log(error);
  }
}

const loadreservation = () => {
  reservation.value = props.reservation
}

onMounted(() => {
  loadreservation()
  getrides()
  getclients()
});

const modifierreservation = async () => {
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
    await api.put(`/api/reservations/${reservation.value.id}`, reservation.value, config);
    visible.value = false;
    window.location.reload();
  } catch (error) {
    console.error("There was an error!", error);
  }
}

const cancel = () => {
  visible.value = false;
}
</script>

<style scoped></style>