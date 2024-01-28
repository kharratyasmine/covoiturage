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
                    <div class="col-md-6">
                        <label for="name" class="form-label">nom</label>
                        <input type="text" class="form-control" id="name" v-model="client.name">

                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" v-model="client.email">

                    </div>
                </div>
                <div class="row">
                
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="phone" class="form-control" id="phone" v-model="client.phone">

                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date de naissance</label>
                        <input type="date" class="form-control" id="date" v-model="client.birth_date">
                    </div>
                </div>
                <br />
                <button type="submit" className="btn btn-outline-primary" @click="modifierUser">
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
const props=defineProps(['client'])

const visible = ref(false);
const client = ref({})

const loadclient = () => {

    client.value = props.client
}
onMounted(() => {

    loadclient()

}
);

const modifierUser = () => {
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

    api.put(`/api/clients/${client.value.id}`, client.value, config)
        .then(() => {
            visible.value = false;
        })
        .catch(error => {
           
            console.error("There was an error!", error);
        });
};


const cancel = () => {
    visible.value = false

}
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

</script>
<style scoped></style>