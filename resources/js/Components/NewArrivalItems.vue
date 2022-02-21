<template>
    <div v-if="newArrivals.length != 0" class="px-12 pt-4">
        <loading :isLoading="isLoading"></loading>
        <div class="bg-orange-200">
            <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="flex items-center justify-between space-x-4">
                <h2 class="text-xl font-bold text-gray-900">New Arrivals</h2>
                <a href="/products/new-arrivals" class="whitespace-nowrap text-sm font-medium text-indigo-600 hover:text-indigo-500">View all<span aria-hidden="true"> &rarr;</span></a>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                    <div v-for="newArrival in newArrivals" :key="newArrival" class="relative group">
                        <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden bg-gray-100">
                        <img :src="generateSrc(newArrival.images)" alt="Payment application dashboard screenshot with transaction table, financial highlights, and main clients on colorful purple background." class="object-center object-cover">
                        <div class="flex items-end opacity-0 p-4 group-hover:opacity-100" aria-hidden="true">
                            <a :href="`/product/${newArrival.id}`" class="w-full bg-white bg-opacity-75 backdrop-filter backdrop-blur py-2 px-4 rounded-md text-sm font-medium text-orange-600 text-center">View Product</a>
                        </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between text-base font-medium text-gray-900 space-x-8">
                        <h3>
                            <a :href="`/product/${newArrival.id}`">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ newArrival.name }}
                            </a>
                        </h3>
                        <p>₱ {{ newArrival.price }}</p>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">{{ newArrival.category.name }}</p>
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
        roundRating(rate) {
            var rate = Math.round(parseFloat(rate) * 10) / 10
            if(Number.isNaN(rate)) {
                return 0
            } else {
                return rate
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
                this.$swal.fire({
                    title: "Added to cart",
                    confirmButtonColor: "#ea580c"
                })
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