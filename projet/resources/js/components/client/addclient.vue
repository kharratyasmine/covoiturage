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
                <label for="name" class="form-label">Nom</label>
                <input type="text" class="form-control" id="name" v-model="client.name">
              </div>
              <div class="col-md-6 ms-auto">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" v-model="client.email">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="phone" class="form-label">Telephone</label>
                <input type="text" class="form-control" id="phone" v-model="client.phone">
              </div>
              <div class="col-md-6">
                <label for="birth_date" class="form-label">Date de naissance</label>
                <input type="date" class="form-control" id="birth_date" v-model="client.birth_date">
              </div>
            </div>
            <br />
            <button type="submit" class="btn btn-outline-primary" @click="addClient">
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
  const client = ref({
    name: "",
    email: "",
    phone: "",
    birth_date: "",
  });
  
  const addClient = async () => {
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
        await api.post("/api/clients/", client.value, config);
        visible.value = false;
        window.location.reload();
    } catch (error) {
    
        console.error(error);
    }
};

  
  const cancel = () => {
    visible.value = false;
  };
  
  </script>
  
  <style scoped></style>
  