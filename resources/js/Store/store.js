import { createStore } from "vuex"

import category from "./Modules/categories"
import product from "./Modules/products"

const store = createStore({
    modules: {
        category,
        product
    },
    state:{
        name: "Vue"
    }
})

export default store