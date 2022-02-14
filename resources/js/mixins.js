export const global = {
    computed: {
        app: () => window.App
    },
    methods: {
       userGreetings(name) {
           return 'Hello, ' + name 
       }
    }
}