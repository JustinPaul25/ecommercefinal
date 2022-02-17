<template>
    <div class="w-full">
        <loading :isLoading="isLoading"></loading>
        <div class="h-full flex flex-col bg-white shadow-xl w-full">
          <div class="w-full flex-1 py-6 overflow-y-auto px-4 sm:px-6">
            <div class="flex items-start justify-between">
              <h2 class="text-lg font-bold text-gray-900" id="slide-over-title">Shopping cart</h2>
            </div>

            <div class="mt-8">
              <div class="flow-root">
                <ul role="list" class="-my-6 divide-y divide-gray-200">
                  <li v-for="item in items" :key="item" class="py-6 flex">
                    <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                      <img :src="generateSrc(item.product.images)" alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt." class="w-full h-full object-center object-cover">
                    </div>

                    <div class="ml-4 flex-1 flex flex-col">
                      <div>
                        <div class="flex justify-between text-base font-medium text-gray-900">
                          <h3>
                            <a href="#"> {{ item.product.name }} </a>
                          </h3>
                          <p class="ml-4 text-gray-900">₱ {{ (parseFloat(item.product.price)*item.quantity) }}</p>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">₱ {{ item.product.price }}</p>
                      </div>
                      <div class="flex-1 flex items-end justify-between text-sm">
                        <p class="text-gray-500">Qty {{ item.quantity }}</p>

                        <div class="flex">
                          <button @click="removeItem(item.id)" class="font-medium text-orange-600 hover:text-orange-500">Remove</button>
                        </div>
                      </div>
                    </div>
                  </li>

                  <!-- More products... -->
                </ul>
              </div>
            </div>
          </div>

          <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
            <div class="flex justify-between text-base font-medium text-gray-900">
              <p>Total</p>
              <p>₱ {{ reduceTotal() }}</p>
            </div>
            <div class="mt-6">
              <a @click="checkOut()" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-orange-600 hover:bg-orange-700">Pick-Up</a>
            </div>
            <div class="mt-6 flex justify-center">
              <div class="md:w-1/3 lg:w-1/3 w-full px-4">
                  <div class="w-full mx-auto">
                      <div class="flex flex-wrap">
                          <div class="w-full">
                              <div class="relative">
                                  <p class="text-gray-900 mb-2 text-2xl tracking-normal leading-7">Card Information:</p>
                                  <div id="card-element"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <div class="mt-6">
              <a @click="onlinePaymantCheckout()" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-orange-600 hover:bg-orange-700">Pay Online</a>
            </div>
            <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
              <p>
                or <a href="/products/all-products" class="text-orange-600 font-medium hover:text-orange-500">Continue Shopping<span aria-hidden="true"> &rarr;</span></a>
              </p>
            </div>
          </div>
        </div>
    </div>
</template>

<script>
  import Loading from "../LoadingSpinner.vue"
  import { loadStripe } from '@stripe/stripe-js';

  export default {
    component: {
      Loading
    },
    data() {
      return {
        items: [],
        isLoading: false,
        stripe: {},
        cardElement: {},
        intentToken: null
      }
    },
    async mounted() {
        this.stripe = await loadStripe("pk_test_ZeCMlVozROsukoQTdZrDmQF200tdMw4SZz");
        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
            }
        });
        this.cardElement.mount('#card-element');
    },
    methods: {
      generateSrc(images) {
            for(var ctr = 0; ctr < images.length; ctr++) {
                if(ctr == 4 && images[ctr] == "") {
                    return "https://free-images.com/lg/9f58/desktop_pc_tower_vector.jpg"
                } else {
                    if(images[ctr] != "") {
                        return images[ctr]
                    }
                }
            }
        },
      reduceTotal() {
        const total = Object.values(this.items).reduce((t, {product, quantity}) => t + (parseFloat(product.price)*quantity), 0)
        return total
      },
      async getItems() {
        this.isLoading = true
        await axios.get('/my-cart')
        .then(response => {
          this.items = response.data.data
          this.isLoading = false
        })
      },
      removeItem(id) {
        this.$swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          this.confirmRemoveItem(id);
        })
      },
      async confirmRemoveItem(id) {
        this.isLoading = true
        await axios.delete(`/${id}/my-cart`)
        .then(response => {
          this.items = response.data.data
          this.isLoading = false
        })
      },
      async onlinePaymantCheckout() {
        this.isLoading = true
        await this.stripe.confirmCardSetup(
            this.intentToken.client_secret, {
                payment_method: {
                    card: this.cardElement,
                    billing_details: {
                        name: this.app.current_user.name
                    }
                }
            }
        ).then(function(result) {
            console.log(result)
            if (result.error) {
                this.addPaymentStatus = 3;
                this.addPaymentStatusError = result.error.message;
                this.isLoading = false
                this.$swal.fire(
                    this.__('Online Purchased Failed'),
                    '',
                    'Error'
                )
            } else {
                this.savePayment( result.setupIntent.payment_method );
                this.name = '';
            }
        }.bind(this));
        // await axios.post(`/my-cart-checkout-mastercard`)
        // .then(response => {
        //   this.items = response.data.data
        //   this.isLoading = false
        // })
      },
      async savePayment(method) {
          axios.post(`/my-cart-checkout-mastercard`, {
              total: this.reduceTotal(),
              payment_method: method
          }).then( function(){
              this.items = response.data.data
              this.isLoading = false
          }.bind(this));
      },
      async checkOut() {
        this.isLoading = true
        await axios.get(`/my-cart-checkout`)
        .then(response => {
          this.items = response.data.data
          this.isLoading = false
        })
      }
    },
    created() {
      this.getItems()
      axios.get(`/user/setup-intent`)
      .then( function( response ){
          console.log(response);
          this.intentToken = response.data;
      }.bind(this));
    }
  }
</script>