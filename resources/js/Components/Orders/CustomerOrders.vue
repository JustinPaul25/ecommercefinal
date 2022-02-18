<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-md mx-4 mt-8">
        <loading :isLoading="isLoading"></loading> 
        <items-modal :datas="items" :isOpen="isOpen" :totalPrice="totalPrice" @productReviewModal="openProductReview" @closeModal="isOpen = false"/>
        <review-modal :cartId="cart" :productId="id" :productName="name" :isOpen="isOpenReview" @closeModal="isOpenReview = false; isOpen = true"/>
        <div class="bg-white px-4 pb-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 pt-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="flex-1 flex items-center justify-start lg:ml-6">
                    <div class="max-w-lg w-full lg:max-w-xs">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Heroicon name: solid/search -->
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            </div>
                            <input v-model="search" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Search" type="search">
                        </div>
                    </div>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">

                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Odd row -->
                            <tr v-for="order in datas" :key="order" class="bg-white">
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ order.id }}</td>
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ order.status == "Item Sold" ? 'Picked Up' : order.status }}</td>
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱ {{ calculateTotal(order.orders)}}</td>
                                <td v-if="order.status == 'Item Sold'" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱ {{ calculateTotal(order.orders)}}</td>
                            </tr>

                            <!-- More people... -->
                        </tbody>
                        </table>
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
        cart: ''
      }
    },
    methods: {
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
        }
    },
    created() {
      //this.getItems()
    }
  }
</script>