<html lang="en">
<head>
    <title>Booj Books</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}">
</head>
<body>
<div id="app" class="container mx-auto rounded shadow-lg">
    <h1 class="text-blue-700 text-5xl center">Booj Books</h1>
    <div class="flex">
        <div class="w-1/4">
            <div class="w-full max-w-xs">
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Title
                        </label>
                        <input v-model="title" class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="title" type="text" placeholder="Title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Author
                        </label>
                        <input v-model="author"
                            class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="author" type="text" placeholder="Author">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            Description
                        </label>
                        <textarea v-model="description"
                            class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="description" placeholder="Description"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                            ISBN
                        </label>
                        <input v-model="isbn"
                            class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="isbn" type="text" placeholder="ISBN">
                    </div>
                    <div class="flex items-center justify-between">
                        <button v-on:click="addBook" class="bg-blue-500 hover:bg-blue-700 text-white fond-bold py-2  px-4 rounded focus:outline-none focus:shadow-outline"
                                type="button">Add Book</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-3/4">
            <div class="pl-4 pt-4 cursor-move">
                <draggable @end="sortBooks" v-model="books">
                    <div v-for="book in books" :key="book.id" v-on:click="examineBook(book)" class="bg-blue-100 border boder-blue-400 text-black-700 px-4 py-3 rounded relative m-1">
                        @{{ book.title }}
                    </div>
                </draggable>
            </div>
        </div>
    </div>
    <div v-if="book">

        <div class="w-full">
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Title
                    </label>
                    <input  v-model="book.title" readonly
                        class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="title" type="text" placeholder="Title">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Author
                    </label>
                    <input v-model="book.author" readonly
                        class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="author" type="text" placeholder="Author">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        Description
                    </label>
                    <textarea  v-model="book.description" readonly
                        class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="description" placeholder="Description"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                        ISBN
                    </label>
                    <input v-model="book.isbn" readonly
                        class="shadow appearance-none border rounded w-full py-2 px-2 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="isbn" type="text" placeholder="ISBN">
                </div>
                <div class="flex items-center justify-between">
                    <button v-on:click="removeBook(book.id)"
                            class="bg-blue-500 hover:bg-blue-700 text-white fond-bold py-2  px-4 rounded focus:outline-none focus:shadow-outline"
                            type="button">Remove Book
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
</html>
