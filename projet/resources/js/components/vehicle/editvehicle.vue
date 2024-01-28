<template>
    <button type="button" class="btn btn-warning rounded-circle" @click="visible = true">
        <span style="color: rgb(233, 240, 241)">
            <i class="fa-solid fa-pen-to-square"></i>
        </span>
    </button>
    <form>
        <div class="card flex justify-content-center">
            <Dialog v-model:visible="visible">
                <div class="row">
                    <div class="col-md-6">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control" id="model" v-model="vehicle.model">
                    </div>
                    <div class="col-md-6">
                        <label for="matricule" class="form-label">matricule</label>
                        <input type="text" class="form-control" id="matricule" v-model="vehicle.matricule">
                    </div>
                </div>
                <div class="row">

                      <div class="col-md-6 ">
                        <label for="driver_id" class="form-label">Nom driver</label>
                        <select class="form-control" v-model="vehicle.driver_id">
                            <option v-for="sc in drivers" :key="sc.id" :value=sc.id>{{ sc.name }}</option>
                        </select>

                    </div>

                </div>
                <file-pond name="test" ref="pond" class-name="my-pond" label-idle="Drop files here..."
                    allow-multiple="false" a ccepted-file-types="image/jpeg, image/png" v-bind:files="myFiles " v-on:init="handleFilePondInit"
                    :server="serverOptions()" />
                <br />
                <button type="submit" class="btn btn-outline-primary" @click="updatevehicle">
                    <i class="fa-solid fa-floppy-disk"></i> Enregistrer
                </button>
                <button type="button" class="btn btn-outline-primary" @click="cancel">
                    <i class="fa-solid fa-floppy-disk"></i> Annuler
                </button>
            </Dialog>
        </div>
    </form>
</template>
  
<script setup>
import api from '../config/api.js';
import { ref, onMounted, defineProps } from "vue";
import Dialog from 'primevue/dialog';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import vueFilePond from 'vue-filepond';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';
import axios from 'axios';

const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);
const props = defineProps(['vehicle']);

const visible = ref(false);
const vehicle = ref({});
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


const loadvehicle = () => {
    vehicle.value = props.vehicle
};

onMounted(() => {
    
    loadvehicle()
    getdriver_id()
  
});

const updatevehicle = () => {
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
    api.put(`/api/vehicles/${vehicle.value.id}`, vehicle.value, config);
            visible.value = false;
        }catch(error) {
            console.error("There was an error!", error);
        }
};

const cancel = () => {
    visible.value = false;
};
const serverOptions = () => {
    console.log('server pond');
    return {
        process: (fieldName, file, metadata, load, error, progress, abort) => {
            const data = new FormData();
            data.append('file', file);
            data.append('upload_preset', 'Ecommerce-cloudinary');
            data.append('cloud_name', 'dmrwjzofg');
            data.append('public_id', file.name);
            axios.post('https://api.cloudinary.com/v1_1/dmrwjzofg/upload', data)
                .then((response) => response.data)
                .then((data) => {
                    console.log(data);
                    vehicle.value.image = data.url;
                    load(data);
                })
                .catch((error) => {
                    console.error('Error uploading file:', error);
                    error('Upload failed');
                    abort();
                });
        },
    };
}; 
const handleFilePondInit = async () => {
    if (vehicle.value.image) {
        myFiles.value = [
            {
                source: vehicle.value.image,
                options: { type: 'local' }
            }
        ]
    }
}
</script>
  
<style scoped></style>
  