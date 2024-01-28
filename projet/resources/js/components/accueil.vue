<template>
  <html>

  <head>
    <title>Covoiturage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="/fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="/css/aos.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <div class="site-wrap" id="home-section">
      <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
          <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
          </div>
        </div>
        <div class="site-mobile-menu-body"></div>
      </div>
      <header class="site-navbar site-navbar-target" role="banner">
        <div class="container">
          <div class="row align-items-center position-relative">
            <div class="col-3 d-flex align-items-center">
              <div class="site-logo">

              </div>
            </div>

          </div>
        </div>
      </header>

      <div class="ftco-blocks-cover-1">
        <div class="site-section-cover overlay" data-stellar-background-ratio="0.5"
          style="background-image: url('./images/aa.jpg')">
          <div class="container">
            <div class="row align-items-center justify-content-center text-center">
              <div class="col-md-7">
                <h1 class="mb-3">Bienvenue à Tawsila!</h1>
                <p></p>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="site-section">
        <div class="container">
          <div class="row text-center">
            <div class="col-lg-12 mb-5 mb-lg-0">
              <h3 class="scissors">Le site de covoiturage en Tunisie</h3>
            </div>
          </div>
          <br />
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td style="width: 50%; text-align: center;">
                  <a href="#" @click.prevent="scrollToRidesSection">
                    <img
                      src="https://res.cloudinary.com/dvvr5uv1d/image/upload/v1705158705/t%C3%A9l%C3%A9chargement_r2ip8b.png"
                      alt="tawsila le site de covoiturage en tunisie" width="225" height="225">
                    <h3>VOUS ÊTES PASSAGER?</h3>
                  </a>
                  <p>
                  <h5>Grâce à tawsila, vous pouvez vous déplacer moins cher et rencontrer de nouveaux
                    amis.</h5>
                  </p>
                </td>

                <td style="width: 50%; text-align: center;">
                  <router-link to="/rideform">
                    <img src="https://res.cloudinary.com/dvvr5uv1d/image/upload/v1705158615/imgpng_uum1ge.png" alt="Image"
                      width="225" height="225">
                    <h3>VOUS ÊTES CONDUCTEUR?</h3>
                  </router-link>
                  <p>
                  <h5>Le covoiturage vous permet de réduire les coûts de vos déplacements.</h5>
                  </p>
                </td>

              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="site-section bg-light" ref="ridesSection">
        <div class="container" ref="owlCarousel">
          <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center">
              <h3 class="scissors text-center">Our Available Rides</h3>
            </div>

          </div>
          <div class="row">
            <div class="col-12">
              <div class="nonloop-block-13 owl-carousel d-flex">
                <div class="item-1 h" v-for="ride in rides" :key="ride.id">
                  <img :src="ride.driver.image" alt="Driver Image" class="img-fluid"
                    style="height: 500px; height: 300px;">
                  <div class="item-1-contents">
                    <h3>{{ ride.driver.name }}</h3>
                    <ul>
                      <li class="d-flex"><span>Vehicle Model: {{ ride.vehicle.model }}</span></li>
                      <li class="d-flex"><span>Pickup Location: {{ ride.pickup_location }}</span></li>
                      <li class="d-flex"><span>Dropoff Location: {{ ride.dropoff_location }}</span></li>
                      <li class="d-flex"><span>Date: {{ ride.date }}</span></li>
                      <li class="d-flex"><span>Cost: {{ ride.cost }}</span></li>
                      <li class="d-flex"><span>Available Places: {{ ride.place_available }}</span></li>
                    </ul>
                    <button class="btn btn-primary custom-blue-button" @click="reserveNow(ride)">Réserver
                      maintenant</button>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="site-section section-3" data-stellar-background-ratio="0.5"
        style="background-image: url('images/aa.jpg');">
        <div class="container">
          <div class="row justify-content-center text-center">
            <div class="col-7 text-center mb-5">
              <h2 class="text-white  primary-color-icon text-center">Tawsilaa</h2>
              <p class="lead text-white mb-5">si vous avez un problème contactez-nous.</p>
              <p><a class="btn btn-primary">
                  <router-link class="nav-link " to="/contact">contactez-nous</router-link></a></p>
            </div>
          </div>
        </div>
      </div>
      <footer class="site-footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-3">
              <img
                src="https://res.cloudinary.com/dvvr5uv1d/image/upload/v1705262204/omLl9VaRpCH5EogVqGbnTjzzsJNfUTxriCMgsW20ZvbYdaIPK_kcYdnhHR8kiUCwVA_uwcdwa.jpg"
                alt="Image" class="img-fluid mb-5">

              <p> Bienvenue dans notre application ! Chez Tawsila, notre passion est de créer une expérience
                exceptionnelle pour vous.</p>
            </div>
            <div class="col-lg-8 ml-auto">
              <div class="row">
                <div class="col-lg-6 ml-auto">
                  <h2 class="footer-heading mb-4">Liens rapides</h2>
                  <ul class="list-unstyled">
                    <li><router-link class="nav-link active" to="/About">About Us</router-link></li>
                    <li><router-link class="nav-link active" to="/Contact">Contact</router-link></li>
                    <li><router-link class="nav-link active" to="/Services">Services</router-link></li>
                    <li><router-link class="nav-link active" to="/register">S'inscrire</router-link></li>
                    <li><router-link class="nav-link active" to="/login">Connecter</router-link></li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <h2 class="footer-heading mb-4">Bulletin</h2>
                  <form action="#" class="d-flex" @submit.prevent="handleSubmit">
                    <input type="text" class="form-control mr-3" placeholder="Email" v-model="email">
                    <input type="submit" value="Send" class="btn btn-primary">
                  </form>

                </div>

              </div>
            </div>
          </div>
          <div class="row pt-5 mt-5 text-center">
            <div class="col-md-12">
              <div class="border-top pt-5">
                <p>Tawsila </p>
              </div>
            </div>

          </div>
        </div>
      </footer>

    </div>
  </body>

  </html>
</template>
  
  
<script>
import api from './config/api';

export default {
  data() {
    return {
      rides: []
    };
  },
  async mounted() {
    try {
      const token = localStorage.getItem('token');
      if (!token) {
        console.error('User is not authenticated');
        return;
      }

      // Include the token in the headers
      const headers = {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      };
      const response = await api.get("/api/rides", headers);
      this.rides = await Promise.all(response.data.map(async ride => {
        const driver = await this.getDriverInfo(ride.driver_id, headers);
        const vehicle = await this.getVehicleInfo(ride.vehicle_id, headers);
        console.log("Driver:", driver);
        console.log("Vehicle:", vehicle);
        return {
          ...ride,
          driver: driver,
          vehicle: vehicle
        };
      }));
    } catch (error) {
      console.error(error);
    }
  },

  methods: {
    async getDriverInfo(driverId, headers) {
      try {
        const driverResponse = await api.get(`/api/drivers/${driverId}`, headers);
        return driverResponse.data;
      } catch (error) {
        console.error(error);
        return {};
      }
    },
    async getVehicleInfo(vehicleId, headers) {
      try {
        const vehicleResponse = await api.get(`/api/vehicles/${vehicleId}`, headers);
        return vehicleResponse.data;
      } catch (error) {
        console.error(error);
        return {};
      }
    },
    reserveNow(ride) {
      // Use Vue Router to navigate to the reservation form component with the ride object
      this.$router.push({ name: 'reservationform', params: { rideId: ride.id } });
    },
    scrollToRidesSection() {
      // Access the element using the ref and scroll to it
      this.$refs.ridesSection.scrollIntoView({ behavior: 'smooth' });
    },
  },
};
</script>
<style>
.custom-blue-button {
  background-color: blue;
  color: white;
  /* Vous pouvez ajuster d'autres styles selon vos préférences */
}
</style>