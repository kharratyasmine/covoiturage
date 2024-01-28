<template>
    <form @submit.prevent="handleSubmit">
        <div class="card" style="width: 50rem;">
            <div class="card-body">
                <h5 class="card-title">Montant à payer : {{ amount }} TND</h5>
                <br />
                <div class="card-text">
                    <div class="form-group">

                        <input type="email" class="form-control" placeholder="email" v-model="email" />

                    </div>
                    <br />
                </div>
                <div id="card-element"></div>
                <br />
                <button type="submit" class="btn btn-success">Procéder au payement</button>
            </div>
        </div>
    </form>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import { loadStripe } from '@stripe/stripe-js';
//import store from '../../store'
import api from "./config/api.js";
import { useRouter } from 'vue-router';
const router = useRouter();
const stripePromise =
    loadStripe('pk_test_51OMBW8Ik8wR5VYrZOjxoPcA2BxD4HINFTz6miHZ6xTHHz56JWpA5wNRMOMbZZsLgATq2fB9vstYx1wRtbLkEr2kI00WuQDBcxx');
const stripe = ref(null);
let cardElement; 
let amount = ref(0);
let email = ref("");
onMounted(async () => {
    amount.value = 100;
    stripe.value = await stripePromise;
    const elements = stripe.value.elements();
    cardElement = elements.create('card'); 
    cardElement.mount('#card-element');
});
const handleSubmit = async () => {
    const { token, error } = await stripe.value.createToken(cardElement);
    if (error) {
        console.error(error);
    } else {
       
        const response = await api.post('/api/createpayment', {
            token: token.id,
            amount: amount.value * 100,
            email: email.value
        });
        if (response.data.message) {
            console.log(response.data.message);
            
            alert(response.data.message);
            
            store.commit('Articlestore/clearCart')
          
            router.push('/shopping')
        } else {
            console.error(response.data.error);
        }
    }
};
</script>