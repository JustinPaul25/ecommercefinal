@extends('vue-layouts.app')

@section('content')
    <section aria-labelledby="social-impact-heading" class="max-w-7xl mx-auto pt-4 px-4 sm:pt-8 sm:px-6 lg:px-8">
        <div class="relative rounded-lg overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://scontent-xsp1-1.xx.fbcdn.net/v/t39.30808-6/272878578_459350332345702_2441667893847870781_n.jpg?_nc_cat=108&ccb=1-5&_nc_sid=174925&_nc_eui2=AeH3jz9TBiToSH1xDuX15vtQBAWrfQkmmdwEBat9CSaZ3PWbivR5Qv0bNVV-9yodPBaNPxJqscyKTWvdc7jkbhwn&_nc_ohc=sW4hFkbmXHwAX8vA_j_&_nc_ht=scontent-xsp1-1.xx&oh=00_AT9p03itzskqAO6A_GzpLNXeVtSxr4u5oy4p3EBouztNMQ&oe=6218D700" alt="" class="w-full h-full object-center object-cover">
        </div>
        <div class="relative bg-gray-900 bg-opacity-75 py-32 px-6 sm:py-40 sm:px-12 lg:px-16">
            <div class="relative max-w-3xl mx-auto flex flex-col items-center text-center">
            <h2 id="social-impact-heading" class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block sm:inline">Ming Computer Solutions - Panabo Branch</span>
            </h2>
            <p class="mt-3 text-xl text-white">Browse - Add To Cart - Checkout</p>
            <p class="mt-3 text-xl text-white">At your finger tips</p>
            <a href="/products/all-products" class="mt-8 w-full block bg-indigo-600 border border-transparent rounded-md py-3 px-8 text-base font-bold text-white hover:bg-indigo-100 sm:w-auto">View Products</a>
            </div>
        </div>
        </div>
    </section>
    @if(auth()->user())
        <recommended></recommended>
    @endif
    <featured-items></featured-items>
    <new-arrival-items></new-arrival-items>
@endsection