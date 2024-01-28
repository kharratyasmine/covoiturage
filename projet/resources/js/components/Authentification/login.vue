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

                            <hr />
                            <label for="email" class="form-label ">
                                <h3 class="mb-3 text-white">Email</h3>
                            </label>
                            <div class="form-floating mb-3">
                                <input id="email" class="form-control" v-model="user.email" type="email"
                                    autocomplete="username" aria-required="true" placeholder="nom@example.com" />
                            </div>

                            <label for="Password" class="form-label ">
                                <h3 class="mb-3 text-white">Mot de passe</h3>
                            </label>
                            <div class="form-floating mb-3">
                                <input id="password" type="password" v-model="user.password" class="form-control"
                                    autocomplete="current-password" required="true" placeholder="mot de passe" />

                            </div>
                            <div>
                                <button id="login-submit" type="submit" class="btn btn-lg btn-primary"
                                    @click="handleLogin">Se connecter</button>
                                <div class="checkbox mb-3">
                                    <label for="RememberMe" class="form-label">
                                        <input class="form-check-input" for="RememberMe" />
                                        Souviens-toi de moi
                                    </label>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </body>
</template>
<script setup>
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter()
let user = {}
const handleLogin = async () => {
    axios.post('http://localhost:8000/api/login/', user)

        .then((response) => {
            router.push("/")
            localStorage.setItem('user', response.data.user.name)
            localStorage.setItem('token', response.data.token)
        })
        .catch(err => {
            console.log(err);
            alert(err)
        })

}
</script>
<style scoped>
.marge {
    position: fixed;
    width: 100%;
    height: 300px;
    margin: 10% auto;
    padding: 20px;
    border: 5px solid #ccc;
    background-color: #fff;
}

.text-white {
    color: #fff;
}
</style>