<template>
    <div>
      <br />
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-default">
            <div class="card-header">
              <h3 style="background-color: #0DCAF0;">
                <center>Driver Registration</center>
              </h3>
            </div>
            <div class="card-body">
              <div class="container">
                <div class="row">
                  <div class="col-12">
                    <form @submit.prevent="handleSubmit">
                      <h4>Driver Information</h4>
                      <hr />
  
                      <label for="driverName" class="form-label">Driver Name</label>
                      <div class="form-floating mb-3">
                        <input id="driverName" class="form-control" v-model="driver.name" type="text" required placeholder="Driver Name" />
                      </div>
  
                      <label for="driverEmail" class="form-label">Driver Email</label>
                      <div class="form-floating mb-3">
                        <input id="driverEmail" class="form-control" v-model="driver.email" type="email" required placeholder="Driver Email" />
                      </div>

                      <label for="driverPhone" class="form-label">Driver Phone</label>
                      <div class="form-floating mb-3">
                        <input id="driverPhone" class="form-control" v-model="driver.phone" type="text" required placeholder="Driver Phone" />
                      </div>

                      <label for="driverBirthdate" class="form-label">Driver Birth Date</label>
                      <div class="form-floating mb-3">
                        <input id="driverBirthdate" class="form-control" v-model="driver.birth_date" type="date" required placeholder="Driver Birth Date" />
                      </div>

                      <label for="DriverImage" class="form-label">Driver Image</label>
                      <div class="form-floating mb-3">
                        <input id="DriverImage" class="form-control" v-model="driver.image" type="text" required placeholder="Driver Image" />
                      </div>
                     
  
                      
  
                      <h4>Car Information</h4>
                      <hr />
  
                      <label for="carModel" class="form-label">Car Model</label>
                      <div class="form-floating mb-3">
                        <input id="carModel" class="form-control" v-model="vehicle.model" type="text" required placeholder="Car Model" />
                      </div>
  
                      <label for="carMatricule" class="form-label">Car Matricule</label>
                      <div class="form-floating mb-3">
                        <input id="carMatricule" class="form-control" v-model="vehicle.matricule" type="text" required placeholder="Car Matricule" />
                      </div>
                      <label for="carImage" class="form-label">Vehicule Image</label>
                      <div class="form-floating mb-3">
                        <input id="carImage" class="form-control" v-model="vehicle.image" type="text" required placeholder="Car Image" />
                      </div>
                      
  
                      
  
                      <h4>Ride Information</h4>
                      <hr />
  
                      <label for="pickupLocation" class="form-label">Pickup Location</label>
                      <div class="form-floating mb-3">
                        <input id="pickupLocation" class="form-control" v-model="ride.pickup_location" type="text" required placeholder="Pickup Location" />
                      </div>
  
                      <label for="dropoffLocation" class="form-label">Dropoff Location</label>
                      <div class="form-floating mb-3">
                        <input id="dropoffLocation" class="form-control" v-model="ride.dropoff_location" type="text" required placeholder="Dropoff Location" />
                      </div>

                      <label for="date" class="form-label">Date</label>
                      <div class="form-floating mb-3">
                        <input id="date" class="form-control" v-model="ride.date" type="date" required placeholder="Date" />
                      </div>

                      <label for="cost" class="form-label">Cost</label>
                      <div class="form-floating mb-3">
                        <input id="cost" class="form-control" v-model="ride.cost" type="text" required placeholder="Cost" />
                      </div>

                      <label for="placeAvailable" class="form-label">place available</label>
                      <div class="form-floating mb-3">
                        <input id="placeAvailable" class="form-control" v-model="ride.place_available" type="text" required placeholder="Place Available" />
                      </div>
                      
  
                      
  
                      <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import { ref } from "vue";
import api from "./config/api.js";

export default {
    data() {
        return {
            driver: {
                name: "",
                email: "",
                image: "",
                birth_date: "",
                phone: ""
            },
            vehicle: {
                model: "",
                matricule: "",
                image: "",
                driver_id: ""
            },
            ride: {
                pickup_location: "",
                dropoff_location: "",
                driver_id: "",
                vehicle_id: "",
                date: "",
                cost: "",
                place_available: ""
            },
        };
    },
    methods: {
        async handleSubmit() {
            try {
                // Step 0: Get the user's token from local storage
                const token = localStorage.getItem('token');

                // Step 1: Create a new driver
                const driverResponse = await api.post("/api/drivers", {
                    name: this.driver.name,
                    email: this.driver.email,
                    image: this.driver.image,
                    birth_date: this.driver.birth_date,
                    phone: this.driver.phone,
                }, { headers: { Authorization: `Bearer ${token}` } });

                // Check the structure of the driverResponse and adjust accordingly
                console.log("Driver Response:", driverResponse.data);

                const driverId = driverResponse.data.id; // Adjust this based on the actual structure
                console.log("Driver ID:", driverId);

                // Step 2: Create a new vehicle with the driver_id obtained from step 1
                const vehicleResponse = await api.post("/api/vehicles", {
                    model: this.vehicle.model,
                    matricule: this.vehicle.matricule,
                    image: this.vehicle.image,
                    driver_id: driverId,
                }, { headers: { Authorization: `Bearer ${token}` } });

                // Check the structure of the vehicleResponse and adjust accordingly
                console.log("Vehicle Response:", vehicleResponse.data);

                const vehicleId = vehicleResponse.data.vehicle.id; // Adjust this based on the actual structure
                console.log("Vehicle ID:", vehicleId);

                // Step 3: Create a new ride with the driver_id and vehicle_id obtained from steps 1 and 2
                const rideResponse = await api.post("/api/rides", {
                    pickup_location: this.ride.pickup_location,
                    dropoff_location: this.ride.dropoff_location,
                    driver_id: driverId,
                    date: this.ride.date,
                    cost: this.ride.cost,
                    place_available: this.ride.place_available,
                }, { headers: { Authorization: `Bearer ${token}` } });

                console.log("Ride Response:", rideResponse.data);

                // Optionally, you can reset the form or perform any other actions after successful submission
                console.log("Form submitted successfully!");
                this.$router.push('/');
            } catch (error) {
                console.error("Error submitting form:", error);
                // Handle error and provide user feedback if needed
            }
        },
    },
};
</script>

  