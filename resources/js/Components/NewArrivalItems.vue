<template>
    <div v-if="newArrivals.length != 0" class="px-12 pt-4">
        <div class="my-20">
            <div class="flex flex-row justify-between my-5">
                <h2 class="text-3xl">New Arrivals</h2>
                <a href="/products/new-arrivals" class="flex flex-row text-lg hover:text-orange-600">
                    View All
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
                </a>
            </div>
            <div class="grid grid-flow-row grid-cols-1 md:grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                <div v-for="newarrival in newArrivals" :key="newarrival" class="shadow-lg rounded-lg">
                    <a href="#">
                        <img :src="generateSrc(newarrival.images)" class="rounded-tl-lg rounded-tr-lg" />
                    </a>
                    <div class="p-5">
                        <h3 class="font-bold"><a href="#">{{ newarrival.name }}</a></h3>
                        <p>₱ {{ newarrival.price }}</p>
                        <ul class="flex items-center gap-x-1">
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 far fa-star"></i>
                            </li>
                        </ul>
                        <p class="text-orange-600">{{ newarrival.category.name }}</p>
                    <div class="flex flex-col xl:flex-row justify-between">
                        <button @click="addToCart(newarrival)" v-if="isLoggedIn()" class="bg-gradient-to-r from-orange-600 to-pink-500 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-600 hover:from-orange-600 hover:to-orange-600 flex flex-row justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to cart
                        </button>
                        <a class="bg-orange-600 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-700 flex flex-row justify-center" :href="`/product/${newarrival.id}`">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            View Details
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</template>

<script>
// If you are using PurgeCSS, make sure to whitelist the carousel CSS classes

export default {
    data() {
        return {
            newArrivals: []
        }
    },
    methods: {
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
                    this.storeToCart(quantity, product)
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
            })
        },
        isLoggedIn() {
            return this.app.logged_in
        },
        async getNewArrivals() {
            await axios.get('/new-arrival')
            .then(response => {
                this.newArrivals = response.data.data
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
        }
    },
    created() {
        this.getNewArrivals()
    }
};
</script>

<style>
    .carousel__next, .carousel__prev {
        background-color: rgb(234, 88, 12);
    }

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