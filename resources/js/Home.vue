<template>
    <div>
        <h1 class="w-full flex justify-center text-4xl font-bold py-5">BANK APP</h1>
        <h1 class="w-full flex justify-center text-2xl font-bold py-5">Customer Details</h1>

        <h4> Customer id  : 31 </h4>
        <h4> Account id : 31  </h4>
        <h4> Balance <span class="p-10"> {{ balance }} </span> </h4>

      <div class="flex justify around"> <p class="font-bold">enter amount</p> : <input v-model="amount" class="shadow appearance-none border mx-5 border-blue-500 rounded py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"  type="text"></div> 
 <button  class="py-2 px-3 bg-gray-200" @click="postDeposit"> Deposit  </button>
 <button class="py-2 px-3 bg-gray-200" @click="postWithdrawal"> Withdraw </button>
      
      <h4  class="text-green-500"> {{  data }}</h4>
      <h4 class="text-red-500"> {{  errors  }}</h4>
    </div>
</template>


<script>
import { defineComponent } from "vue"
import { ref, onMounted } from "vue";
import axios from 'axios';


export default defineComponent({
    name: "home",

    setup() {
        // Your setup logic here
        const balance = ref(null);
        const deposit = ref(null);
        const withdrawal = ref(null);
        const data = ref('');
        const amount = ref(null);
        const errors = ref(null);
        const getBalance = () => {
            
            axios
                .get("/api/balance", {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then((response) => {
                    console.log(response.data);
                    balance.value = response.data.balance;
                })
                .catch((error) => {
                    console.log(error);
                    errors.value = error.response.data.error
                });
        
        };

        const postDeposit = () => {
            console.log(amount.value);
            axios
                .post("/api/deposit", {
                    amount: amount.value
                }, {
                        headers: {
                            Accept: "application/json",
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                 
                        },
                    })
                .then((response) => {
                    console.log(response.data);
                    data.value = response.data.message;
                })
                .catch((error) => {
                    console.log(error);
                    errors.value = error.response.data.error
                    console.log(error.value)
                });
        

        }
   const postWithdrawal = ()=> {
    
            axios
                .post("/api/withdrawal", {
                    amount: amount.value
                }, {
                    headers: {
                        Accept: "application/json",
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                      
                    },
                })
                .then((response) => {
                    console.log(response.data);
                    data.value = response.data.message;
                })
                .catch((error) => {
                    console.log(error);
                    errors.value = error.response.data.error
               
                });
        
   }

        onMounted(() => {
            getBalance();
        });


        return {
            getBalance,
            balance,
            deposit,
            withdrawal,
            postDeposit,
            postWithdrawal,
            data,
            amount,
            errors

   

        };
    },
});
</script>

