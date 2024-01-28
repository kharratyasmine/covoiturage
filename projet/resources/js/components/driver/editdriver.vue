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
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" v-model="driver.name">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" v-model="driver.email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="phone" class="form-control" id="phone" v-model="driver.phone">
                    </div>
                    <div class="col-md-6">
                        <label for="birthdate" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="birthdate" v-model="driver.birth_date">
                    </div>
                </div>
                <file-pond name="test" ref="pond" class-name="my-pond" label-idle="Drop files here..."
                    allow-multiple="false" a ccepted-file-types="image/jpeg, image/png" v-bind:files="myFiles " v-on:init="handleFilePondInit"
                    :server="serverOptions()" />
                <br />
                <button type="submit" class="btn btn-outline-primary" @click="updateDriver">
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
const props = defineProps(['driver']);

const visible = ref(false);
const driver = ref({});

const loadDriver = () => {
    driver.value = props.driver;
};

onMounted(() => {
    loadDriver();
});

const updateDriver = async () => {
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
        await api.put(`/api/drivers/${driver.value.id}`, driver.value, config);
        visible.value = false;
    } catch (error) {
        // Gérer l'erreur, par exemple, afficher un message à l'utilisateur
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
                    driver.value.image = data.url;
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
    if (driver.value.image) {
        myFiles.value = [
            {
                source: driver.value.image,
                options: { type: 'local' }
            }
        ]
    }
}
</script>
  
<style scoped></style>
  