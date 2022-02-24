require('./bootstrap')

import { createApp } from "vue";
import store from "./store/store";
import { global } from './mixins';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue3-carousel/dist/carousel.css';

import HelloWorld from './components/Welcome'
import Products from './Components/Products/Products'
import Categories from './Components/Categories/Categories'
import FeaturedItems from './Components/FeaturedItems'
import NewArrivalItems from './Components/NewArrivalItems'
import Recommended from './Components/Recommended'
import ProductGrid from './Components/Products/ProductGrid'
import ProductDetail from './Components/Products/ProductDetail'
import CartItems from './Components/Checkout/CartItems'
import Messages from './Components/Message/Messages'
import Orders from './Components/Orders/Orders'
import CustomerOrders from './Components/Orders/CustomerOrders'
import Cashier from './Components/Cashier/Cashier'
import Report from './Components/Reports/Reports'
import Settings from './Components/Settings'
import ChangePassword from './Components/ChangePassword'
import UserIcons from './Components/UserIcons'

const app = createApp({
    store,
    components: {
        HelloWorld,
        Products,
        Categories,
        FeaturedItems,
        NewArrivalItems,
        ProductGrid,
        ProductDetail,
        CartItems,
        Messages,
        Orders,
        CustomerOrders,
        Cashier,
        Report,
        Recommended,
        Settings,
        ChangePassword,
        UserIcons
    }
})
app.mixin(global)

app.use(store)
.use(VueSweetalert2)
.mount("#app")

document.addEventListener('DOMContentLoaded', () => {
    // const navMenu = document.querySelector('#nav-menu')
    const navSubMenu = document.querySelector('#nav-sub-menu')
    const hamburger = document.querySelector('#hamburger')
    const mobileMenu = document.querySelector('#mobile-menu')
    const mobileUserMenu = document.querySelector('#mobile-user-menu')
    const userMenuButton = document.querySelector('#user-menu-button')
    const userMenu = document.querySelector('#user-menu')
  
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            // navMenu.classList.toggle('hidden')
            navSubMenu.classList.toggle('hidden')
        })
    }

    if (mobileUserMenu) {
        mobileUserMenu.addEventListener('click', () => {
            // navMenu.classList.toggle('hidden')
            mobileMenu.classList.toggle('hidden')
        })
    }

    if (userMenuButton) {
        userMenuButton.addEventListener('click', () => {
            // navMenu.classList.toggle('hidden')
            userMenu.classList.toggle('hidden')
        })
    }
})