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
                        <div class="col-md-6">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="model" v-model="Vehicle.model">
                        </div>
                        <div class="col-md-6 ms-auto">
                            <label for="matricule" class="form-label">matricule</label>
                            <input type="text" class="form-control" id="matricule" v-model="Vehicle.matricule">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 ">
                        <label for="driver_id" class="form-label">Driver</label>
                        <select class="form-control" v-model="Vehicle.driver_id">
                            <option v-for="dr in drivers " :key="dr.id" :value=dr.id>{{ dr.name }} </option>
                        </select>

                    </div>
                    </div>
                    <file-pond name="test" ref="pond" class-name="my-pond" label-idle="Drop files here..."
                        allow-multiple="false" a ccepted-file-types="image/jpeg, image/png" v-bind:files="myFiles"
                        :server="serverOptions()" />
                    <br />
                    <button type="submit" class="btn btn-outline-primary" @click="addVehicle">
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
import { ref , onMounted} from "vue";
import api from "../config/api.js";
import Dialog from "primevue/dialog";
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import vueFilePond from 'vue-filepond';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import 'filepond/dist/filepond.min.css';
import axios from 'axios';

const FilePond = vueFilePond(FilePondPluginImagePreview);
const myFiles = ref([]);
const visible = ref(false);
const Vehicle = ref({
    Model: "",
    matricule: "",
    driver_id: "",
    image: ""
});
const drivers = ref([]);
const token = localStorage.getItem('token');
const getdrivers = () => {

api.get('/api/drivers', { headers: { Authorization: `Bearer ${token}` } })
.then(res => {
  drivers.value = res.data;
}).catch(error => {
    if (error.response.status === 401) {
    
    } else {
      console.error('Erreur inattendue :', error);
    }
  });
};

onMounted(() => {
    getdrivers();
   
}
  );

  const addVehicle = async () => {
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
        // Assuming you have an API endpoint that requires authentication for adding a vehicle
        await api.post('/api/vehicles/', Vehicle.value, config);

        // If you want to reload the page after adding a vehicle
        visible.value = false;
        window.location.reload();
    } catch (error) {
        console.error(error);
      
    }
};


const cancel = () => {
    visible.value = false;
};
const serverOptions = () => { console.log('server pond');
    return {
    process: (fieldName, file, metadata, load, error, progress, abort) => {
    const data = new FormData();
    data.append('file', file);
    data.append('upload_preset', 'Ecommerce-cloudinary');
    data.append('cloud_name', 'dmrwjzofg');
    data.append('public_id', file.name);
    axios.post('https://api.cloudinary.com/v1_1/dmrwjzofg/upload',data)
    .then((response) => response.data)
    .then((data) => {
    console.log(data);
    Vehicle.value.image = data.url;
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
</script>
  
<style scoped></style>
  