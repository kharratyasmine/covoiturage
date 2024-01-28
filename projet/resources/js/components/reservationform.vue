<template>
    <div>
        <br />
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 style="background-color: #0DCAF0;">
                            <center>Client Registration</center>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <form @submit.prevent="handleSubmit">
                                        <h4>Client Information</h4>
                                        <hr />

                                        <label for="clientName" class="form-label">Client Name</label>
                                        <div class="form-floating mb-3">
                                            <input id="clientName" class="form-control" v-model="client.name" type="text"
                                                required placeholder="Client Name" />
                                        </div>

                                        <label for="clientEmail" class="form-label">Client Email</label>
                                        <div class="form-floating mb-3">
                                            <input id="clientEmail" class="form-control" v-model="client.email" type="email"
                                                required placeholder="Client Email" />
                                        </div>

                                        <label for="clientPhone" class="form-label">Client Phone</label>
                                        <div class="form-floating mb-3">
                                            <input id="clientPhone" class="form-control" v-model="client.phone" type="text"
                                                required placeholder="Client Phone" />
                                        </div>

                                        <label for="clientBirthdate" class="form-label">Client Birth Date</label>
                                        <div class="form-floating mb-3">
                                            <input id="clientBirthdate" class="form-control" v-model="client.birth_date"
                                                type="date" required placeholder="Client Birth Date" />
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
import { ref, onMounted } from "vue";
import api from "./config/api.js";

export default {
    props: ['rideId'],
    data() {
        return {
            client: {
                name: "",
                email: "",
                birth_date: "",
                phone: "",
            },
            token: localStorage.getItem('token'), // Move token to data
        };
    },
    async mounted() {
        try {
            
            if (!this.token) {
                console.error("Token not found. Please log in."); 
                return;
            }

            
            const rideId = this.$route.params.rideId;
            const rideResponse = await api.get(`/api/rides/${rideId}`, { headers: { Authorization: `Bearer ${this.token}` } });
            console.log("Ride Response:", rideResponse.data);

           

        } catch (error) {
            console.error("Error fetching data:", error);
           
        }
    },
    methods: {
        async handleSubmit() {
    try {
        
        if (!this.token) {
            console.error("Token not found. Please log in."); 
            return;
        }

       
        const clientResponse = await api.post("/api/clients", {
            name: this.client.name,
            email: this.client.email,
            birth_date: this.client.birth_date,
            phone: this.client.phone,
        }, { headers: { Authorization: `Bearer ${this.token}` } });

        
        console.log("Client Response:", clientResponse.data);

        const clientId = clientResponse.data.id; 
        console.log("Client ID:", clientId);

        
        const reservationResponse = await api.post("/api/reservations", {
            client_id: clientId,
            ride_id: this.$route.params.rideId,
        }, { headers: { Authorization: `Bearer ${this.token}` } });

        
        const rideId = this.$route.params.rideId;
        const rideResponse = await api.get(`/api/rides/${rideId}`, { headers: { Authorization: `Bearer ${this.token}` } });
        const updatedAvailablePlaces = rideResponse.data.place_available - 1;

        
        const updateRideResponse = await api.patch(`/api/rides/${rideId}`, {
            place_available: updatedAvailablePlaces,
        }, { headers: { Authorization: `Bearer ${this.token}` } });

 
        console.log("Reservation Response:", reservationResponse.data);
        console.log("Updated Ride Response:", updateRideResponse.data);
        console.log("Form submitted successfully!");

        this.$router.push("/");
    } catch (error) {
        console.error("Error submitting form:", error);
        
    }
},

    },
};
</script>
