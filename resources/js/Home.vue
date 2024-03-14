<template>
    <div>
        <h1 class="w-full flex justify-center text-4xl font-bold py-5">BANK APP</h1>
        <h1 class="w-full flex justify-center text-2xl font-bold py-5">Customer Details</h1>

        <h4> Customer id </h4>
        <h4> Account id </h4>
        <h4> Balance <span class="p-10"> {{ balance }} </span> </h4>

      <div class="flex justify around"> <p>enter amount</p> : <input type="text" name="" id="" v-model="amount"> </div> 
 <button  class="py-2 px-3 bg-gray-200" @click="postDeposit()"> Deposit  </button>
 <button class="py-2 px-3 bg-gray-200" @click="postWithdrawal()"> WIthdraw </button>
      
      <h4> {{  data }}</h4>
    </div>
</template>


<script>
import { defineComponent } from "vue"
import { ref, onMounted } from "vue";


export default defineComponent({
    name: "home",

    setup() {
        // Your setup logic here
        const balance = ref(null);
        const deposit = ref(null);
        const withdrawal = ref(null);
        const data = ref('');
        const amount = ref(null);
        const getBalance = () => {
            
            axios
                .get("/api/getBalance", {
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
                });
        
        };

        const postDeposit = () => {
            
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
                });
        

        }
   const postWithdrawal = ()=> {
    {
            axios
                .get("/api/withdrawal", {
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
                });
        }
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
            amount

   

        };
    },
});
</script>

