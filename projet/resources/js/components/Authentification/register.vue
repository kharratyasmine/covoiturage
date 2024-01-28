<template>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="fonts/icomoon/style.css">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-datepicker.css">
        <link rel="stylesheet" href="css/jquery.fancybox.min.css">
        <link rel="stylesheet" href="css/owl.carousel.min.css">
        <link rel="stylesheet" href="css/owl.theme.default.min.css">
        <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
        <link rel="stylesheet" href="css/aos.css">

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="css/style.css">

    </head>

    <body>
        <div class="ftco-blocks-cover-1">
            <div class="site-section-cover overlay" data-stellar-background-ratio="0"
                style="background-image: url('images/aa.jpg')">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">

                        <form>
                          <br>
                            <label for="name" class="form-label  ">
                                <h3 class="mb-3 text-white">Name</h3>
                            </label>
                            
                            <div class="form-floating mb-3">
                                <input id="name" class="form-control" v-model="user.name" type="text" autocomplete=""
                                    required autofocus placeholder="username" />
                            </div>
                            <label for="email" class="form-label ">
                                <h3 class="mb-3 text-white">Addresse Email</h3>
                            </label>
                            
                            <div class="form-floating mb-3">
                                <input id="email" class="form-control" v-model="user.email" type="email" autocomplete="off"
                                    required autofocus placeholder="username" />
                            </div>
                            <label for="Password" class="form-label ">
                                <h3 class="mb-3 text-white">Mot de passe</h3>
                            </label>
                            
                            <div class="form-floating mb-3">
                                <input id="password" type="password" v-model="user.password" class="form-control"
                                    autocomplete="current-password" required placeholder="mot de passe" />
                            </div>
                            <label for="Password" class="form-label ">
                                <h3 class="mb-3 text-white">Confirmation mot de passe</h3>
                            </label>
                           
                            <div class="form-floating mb-3">
                                <input id="password_confirmation" type="password" v-model="user.password_confirmation"
                                    class="form-control" autocomplete="current-password" required
                                    placeholder="mot de passe" />
                            </div>

                            <button type="submit" class="btn btn-primary" @click="handleSubmit">Registre</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </body>
</template>
<script setup>
import axios from "axios"
import { useRouter } from 'vue-router';
const router = useRouter()
let user = {}

const handleSubmit = async () => {
    axios.post('http://localhost:8000/api/register/', user)

        .then(response => {
            console.log(response)
            router.replace({ name: 'login' })
        })
        .catch(err => { console.log(err); alert(err) })

}
</script>
<style scoped>
.marge {
    position: fixed;
    width: 100%;
    height: 300px;
    margin: 5% auto;
    padding: 20px;
    border: 5px solid #ccc;
    background-color: #fff;
}</style>