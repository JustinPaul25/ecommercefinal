<template>
    <div v-if="hotDeals.length != 0" class="px-12">
        <loading :isLoading="isLoading"></loading>
        <div class="bg-orange-200">
            <div class="max-w-2xl mx-auto py-4 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="flex items-center justify-between space-x-4">
                <h2 class="text-xl font-bold text-gray-900">Hot Deals</h2>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                    <div v-for="product in hotDeals" :key="product" class="shadow-lg bg-white rounded-lg">
                        <a href="#">
                            <img :src="generateSrc(product.images)" class="rounded-tl-lg rounded-tr-lg" />
                        </a>
                        <div class="p-2">
                            <h3 class="font-bold"><a href="#">{{ product.name }}</a></h3>
                            <h3><a href="#">{{ product.brand }}</a></h3>
                            <h3 class="text-orange-600"><a href="#">{{ product.category.name }}</a></h3>
                            <p class="text-base text-gray-800">
                                ₱ {{ formatPrice(product.price) }}
                            </p>
                            <ul class="flex items-center gap-x-1">
                                <li>
                                    <i class="text-yellow-300 fas fa-star"></i> {{ roundRating(product.rating.rating) }}
                                </li>
                            </ul>
                            <ul class="flex items-center gap-x-1">
                                <li>
                                    <span class="text-orange-600">{{ product.rating.count }} Reviews</span>
                                </li>
                            </ul>
                            <p class="text-gray-600">{{ product.stock }} pcs. Remaining</p>
                            <div class="flex flex-col xl:flex-row justify-between">
                                <button @click="addToCart(product)" v-if="isLoggedIn()" class="bg-gradient-to-r from-orange-600 to-pink-500 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-600 hover:from-orange-600 hover:to-orange-600 flex flex-row justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to cart
                                </button>
                                <a :href="`/product/${product.id}`" class="bg-orange-600 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-700 flex flex-row justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <section aria-labelledby="social-impact-heading" class="max-w-7xl mx-auto pt-4 px-4 sm:pt-8 sm:px-6 lg:px-8">
                    <div class="relative rounded-lg overflow-hidden">
                    <div class="absolute inset-0">
                        <img src="https://cdn.stocksnap.io/img-thumbs/960w/computer-board_FVH1SDZJGI.jpg" alt="" class="w-full h-full object-center object-cover">
                    </div>
                    <div class="relative bg-gray-900 bg-opacity-75 py-32 px-6 sm:py-40 sm:px-12 lg:px-16">
                        <div class="relative max-w-3xl mx-auto flex flex-col items-center text-center">
                        <h2 id="social-impact-heading" class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            <span class="block sm:inline">Ming Computer Solutions - Panabo Branch</span>
                        </h2>
                        <p class="mt-3 text-xl text-white">Browse - Add To Cart - Checkout</p>
                        <p class="mt-3 text-xl text-white">At your finger tips</p>
                        <a href="/products/hot-deals" class="mt-8 w-full block bg-orange-600 border border-transparent rounded-md py-3 px-8 text-base font-bold text-white hover:bg-orange-100 sm:w-auto">View Featured Products</a>
                        </div>
                    </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from "./LoadingSpinner.vue"

export default {
    components: {
        Loading
    },
    data() {
        return {
            hotDeals: [],
            isLoading: false
        }
    },
    methods: {
        connect(id) {
            window.Echo.join(`updateproduct`)
            .listen('UpateProduct', e => {
                this.getHotDeals()
            })
        },
        roundRating(rate) {
            var rate = Math.round(parseFloat(rate) * 10) / 10
            if(Number.isNaN(rate)) {
                return 0
            } else {
                return rate
            }
        },
        isLoggedIn() {
            if(this.app.logged_in) {
                if(this.app.is_admin) {
                    return false
                } else {
                    return true
                }
            } else {
                return false
            }
        },
        async getHotDeals() {
            await axios.get('/hot-deals')
            .then(response => {
                this.hotDeals = response.data.data
            })
        },
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
        addToCart(product) {
            var form = {
                product_id: product.id
            }

            this.$swal.fire({
                title: 'How many would you like to purchase?',
                input: 'number',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Add to Cart',
                confirmButtonColor: '#EA580C',
                showLoaderOnConfirm: true,
                preConfirm: (quantity) => {
                    if(quantity > product.stock) {
                        this.$swal.fire('Insufficient Stock')
                    } else {
                        this.storeToCart(quantity, product)
                    }
                },
                allowOutsideClick: () => !this.$swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    
                }
            })
        },
        async storeToCart(quantity, product) {
            var form = {
                product_id: product.id,
                quantity: quantity
            }
            this.isLoading = true
            await axios.post('/add-to-cart', form)
            .then(response => {
                this.isLoading = false
                this.$swal.fire({
                    title: "Added to cart",
                    confirmButtonColor: "#ea580c"
                })
            })
            await this.$store.dispatch('cart/addCart')
        }
    },
    created() {
        this.getHotDeals()
        this.connect()
    }
};
</script>

<style scoped>
    .carousel__slide > .carousel__item {
        height: 400px;
        transform: scale(1);
        opacity: 0.5;
        transition: 0.5s;
    }
    .carousel__slide--visible > .carousel__item {
        opacity: 1;
        transform: rotateY(0);
    }
    .carousel__slide--next > .carousel__item {
        transform: scale(0.9) translate(-10px);
    }
    .carousel__slide--prev > .carousel__item {
        transform: scale(0.9) translate(10px);
    }
    .carousel__slide--active > .carousel__item {
        transform: scale(1.1);
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
        color: rgb(36, 35, 35);
    }

    .price {
        color: grey;
        font-size: 22px;
    }

    .card button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: rgb(234, 88, 12);
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    .card button:hover {
        opacity: 0.7;
    }
</style>