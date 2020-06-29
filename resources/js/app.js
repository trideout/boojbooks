import Vue from 'vue'
import axios from 'axios'
import VueAxios from 'vue-axios'
import draggable from "vuedraggable"

Vue.use(VueAxios, axios);
var app = new Vue({
    el: '#app',
    data: {
        title: '',
        author: '',
        description: '',
        isbn: '',
        book: false,
        books: []
    },
    methods: {
        async getBooks () {
            const { data } = await this.$http.post('/api/getBooks');
            this.books = data;
        },
        async addBook() {
            await this.$http.post('/api/addBook', {
                title: this.title,
                author: this.author,
                description: this.description,
                isbn: this.isbn,
            });
            this.title = '';
            this.author = '';
            this.description = '';
            this.isbn = '';
            await this.getBooks();
        },
        examineBook(book){
            this.book = book;
        },
        async removeBook(id){
            await this.$http.post('/api/removeBook', {
                book_id: id
            })
            this.book = false;
            await this.getBooks();
        },
        async sortBooks(evt){
            console.log(evt);
            console.log(this.books.map(book => book.id));
            await this.$http.post('/api/sortBooks', {
                books: this.books.map(book => book.id)
            });
            await this.getBooks();
        }
    },
    components: {
        draggable
    },
    async created(){
        await this.getBooks();

    }
});
