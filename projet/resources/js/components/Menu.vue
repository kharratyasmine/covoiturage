<template>
  <nav class="navbar navbar-expand-lg bg-info" data-bs-theme="dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Covoiturage</a>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarColor01"
        aria-controls="navbarColor01"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarColor01">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link active" to="/client">Clients</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/driver">Drivers</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/Reservation">Reservations</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/Vehicle">Vehicules</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/ride">Rides</router-link>
          </li>
        </ul>

        <!-- Right-aligned items -->
        <ul class="navbar-nav">
          
          <li class="nav-item">
           
            <router-link class="nav-link" to="/login"><i class="fa-solid fa-sign-in-alt"  title="Se connecter"></i></router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/register">
        <i class="fa-solid fa-user-plus"  title=" S'inscrire"></i> 
      </router-link>
          </li>
          <li class="nav-item">
            <button @click="logout" class="nav-link"><i class="fa-solid fa-sign-out-alt"  title="Déconnecter"> </i></button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
   
  <script setup>
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  const router = useRouter();
  const logout = async () => {
    let token = ""
    token = localStorage.getItem('token')
    console.log(token)
    axios.post('http://localhost:8000/api/logout', null, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    })
      .then((response) => {
        console.log(response)
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        router.push("/login")
      })
      .catch(err => { console.log(err); alert(err) })
  }
  
  </script>