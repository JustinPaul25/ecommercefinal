<template>
    <div class="bg-orange-200 shadow overflow-hidden sm:rounded-md mx-4 mt-8">
        <h2 class="ml-8 mt-8 text-3xl tracking-tight font-extrabold text-gray-900 sm:text-4xl">My Orders</h2>
        <loading :isLoading="isLoading"></loading> 
        <items-modal :datas="items" :isOpen="isOpen" :totalPrice="totalPrice" @productReviewModal="openProductReview" @closeModal="isOpen = false"/>
        <review-modal :cartId="cart" :productId="id" :productName="name" :isOpen="isOpenReview" @closeModal="isOpenReview = false; isOpen = true"/>
        <div class="mt-4" v-for="order in datas" :key="order">
            <div @click="openModal(order)" class="bg-white border-t border-b border-gray-200 shadow-sm sm:border rounded rounded-b-none">
                <div class="py-6 px-4 sm:px-6 lg:grid lg:grid-cols-12 lg:gap-x-8 lg:p-8">
                    <div class="sm:flex lg:col-span-7">
                    <div class="mt-6 sm:mt-0 sm:ml-6">
                        <h3 class="text-base font-medium text-gray-900">
                        <a href="#">Order Ref: {{ order.id }}</a>
                        </h3>
                        <p class="mt-2 text-sm font-medium text-gray-900">Total:</p>
                        <p class="mt-2 text-xl font-bold text-gray-900">₱ {{ calculateTotal(order.orders)}}</p>
                    </div>
                    </div>

                    <div class="mt-6 lg:mt-0 lg:col-span-5">
                    <dl class="grid grid-cols-2 gap-x-6 text-sm">
                        <div>
                        <dt class="font-medium text-gray-900">Delivery address</dt>
                        <dd class="mt-3 text-gray-500">
                            <span class="block">{{ user.brgy }}</span>
                            <span class="block">{{ user.city }}</span>
                        </dd>
                        </div>
                        <div>
                        <dt class="font-medium text-gray-900">Shipping updates</dt>
                        <dd class="mt-3 text-gray-500 space-y-3">
                            <p>{{ user.email }}</p>
                            <p>{{ user.phone_no }}</p>
                        </dd>
                        </div>
                    </dl>
                    </div>
                </div>
                </div>
                <div class="border-t bg-white border-gray-200 py-6 px-4 sm:px-6 lg:p-8 rounded rounded-t-none">
                    <h4 class="sr-only">Status</h4>
                    <button @click="cancelOrder(order)" v-if="cancelButton(order)" type="button" class="font-medium text-indigo-600 hover:text-indigo-500">Cancel Order</button>
                    <div v-if="order.status != 'cancelled'" class="mt-6" aria-hidden="true">
                        <div class="bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-2 bg-indigo-600 rounded-full" :style="`width: calc(${status(order.status)})`"></div>
                        </div>
                            <div class="hidden sm:grid grid-cols-3 text-sm font-medium text-gray-600 mt-6">
                            <div class="text-indigo-600">Processing</div>
                            <div v-if="order.status == 'ready for pick-up' || order.status == 'sold'" class="text-center text-indigo-600">Ready For PickUp</div>
                            <div v-else class="text-center">Ready For PickUp</div>
                            <div v-if="order.status == 'sold'" class="text-right text-indigo-600">Sold</div>
                            <div v-else class="text-right">Sold</div>
                        </div>
                    </div>
                    <div v-else class="mt-6" aria-hidden="true">
                        <div class="bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-2 bg-red-600 rounded-full" :style="`width: calc(100%)`"></div>
                        </div>
                        <div class="hidden sm:grid grid-cols-1 text-sm font-medium text-gray-600 mt-6">
                            <div class="text-center">cancelled</div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
  import Loading from "../LoadingSpinner.vue"
  import ItemsModal from "./Modals/ItemsModal.vue"
  import ReviewModal from "./Modals/ReviewModal.vue"

  export default {
    props: {
        datas: Object
    },
    components: {
      Loading,
      ItemsModal,
      ReviewModal
    },
    data() {
      return {
        items: [],
        isLoading: false,
        isOpen: false,
        isOpenReview: false,
        search: "",
        totalPrice: "0",
        id: 0,
        name: '',
        cart: '',
        user: null
      }
    },
    methods: {
        cancelButton(order) {
            if(order.method == 'e-payment' || order.status == 'cancelled') {
                return false
            } else {
                if(order.status != 'sold') {
                    return true
                } else {
                    return false
                }
            }
        },
        cancelOrder(order) {
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.processCancel(order)
                }
            })
            
        },
        async processCancel(order) {
            await axios.get(`/cancel-order/${order.id}`)
            .then(response => {
                this.orders = response.data.data
                this.isLoading = false
            })
        },
        status(status) {
            if(status == 'processing') {
                return '0%'
            }
            if(status == 'ready for pick-up') {
                return '50%'
            }
            if(status == 'sold') {
                return '100%'
            }
        },
        openProductReview(product) {
            this.id = product.product.id
            this.name = product.product.name
            this.isOpen = false
            this.isOpenReview = true
        },
        calculateTotal(items) {
            const total = Object.values(items).reduce((t, {product, quantity}) => t + (parseFloat(product.price)*quantity), 0)
            return total
        },
        openModal(cart) {
            console.log(cart)
            this.cart = cart.id
            this.isOpen = true
            this.items = cart
            this.totalPrice = this.calculateTotal(cart.orders)
        },
        async orderSeen() {
            await axios.get('/seen-order')
        }
    },
    created() {
        this.user = this.app.current_user
        this.orderSeen()
    }
  }
</script>