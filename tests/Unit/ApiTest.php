<?php

class ApiTest extends \Tests\TestCase {
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    private $books = [
        ['Code Complete', 'Steve McConnell', 'Widely considered one of the best practical guides to programming, Steve McConnell’s original CODE COMPLETE has been helping developers write better software for more than a decade. Now this classic book has been fully updated and revised with leading-edge practices—and hundreds of new code samples—illustrating the art and science of software construction. Capturing the body of knowledge available from research, academia, and everyday commercial practice, McConnell synthesizes the most effective techniques and must-know principles into clear, pragmatic guidance. No matter what your experience level, development environment, or project size, this book will inform and stimulate your thinking—and help you build the highest quality code.', '0735619670'],
        ['Design Patterns', 'Erich Gamma', 'Capturing a wealth of experience about the design of object-oriented software, four top-notch designers present a catalog of simple and succinct solutions to commonly occurring design problems. Previously undocumented, these 23 patterns allow designers to create more flexible, elegant, and ultimately reusable designs without having to rediscover the design solutions themselves.', '0201633612'],
        ['Patterns of Enterprise Application Architecture', 'Martin Fowler', 'The practice of enterprise application development has benefited from the emergence of many new enabling technologies. Multi-tiered object-oriented platforms, such as Java and .NET, have become commonplace. These new tools and technologies are capable of building powerful applications, but they are not easily implemented. Common failures in enterprise applications often occur because their developers do not understand the architectural lessons that experienced object developers have learned.', '0321127420'],
        ['Building Microservices', 'Sam Newman', 'Distributed systems have become more fine-grained in the past 10 years, shifting from code-heavy monolithic applications to smaller, self-contained microservices. But developing these systems brings its own set of headaches. With lots of examples and practical advice, this book takes a holistic view of the topics that system architects and administrators must consider when building, managing, and evolving microservice architectures.', '1491950358'],
    ];

    /**
     * @dataProvider bookProvider
     */
    public function testAddBook($title, $author, $description, $isbn){
        //Add all books
        $response = $this->postJson(config('app.url') . '/api/addBook', [
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'isbn' => $isbn,
        ]);

        $response->assertStatus(200)
            ->assertJson(['created' => true]);

        //validate exists in db
        $this->assertDatabaseHas('books', [
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'isbn' => $isbn,
        ]);
    }

    public function testRemoveBook(){
        $book = \App\Book::create([
            'title' => 'Test Book',
            'author' => 'Test Author',
            'description' => 'Test Description',
            'sort' => 0,
            'isbn' => '00000001',
        ]);

        $response = $this->postJson(config('app.url') . '/api/removeBook', [
            'book_id' => $book->id,
        ]);

        $response->assertJson(['deleted' => true]);

        $this->assertDatabaseMissing('books', ['title' => 'Test Book']);
    }

    public function testGetBooks(){
        $this->insertTestBooks();
        $response = $this->postJson(config('app.url') . '/api/getBooks');
        $response->assertStatus(200);
        $data = json_decode($response->content(), true)[0];
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('author', $data);
        $this->assertArrayHasKey('description', $data);
        $this->assertArrayHasKey('isbn', $data);
        $this->assertArrayHasKey('sort', $data);
    }

    public function testSortBooks(){
        $this->insertTestBooks();
        $books = \App\Book::pluck('id')->toArray();
        shuffle($books);

        $response = $this->postJson(config('app.url') . '/api/sortBooks', ['books' => $books]);
        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $sortedBooks = \App\Book::orderBy('sort')->pluck('id')->toArray();
        foreach($sortedBooks as $book){
            $this->assertEquals($books, $sortedBooks);
        }
    }

    public function testValidationFails(){
        $response = $this->postJson(config('app.url') . '/api/addBook', [
            'author' => 'sample author',
            'isbn' => '00000000',
        ]);

        $response->assertStatus(422);
    }

    public function bookProvider(){
        return $this->books;
    }

    public function insertTestBooks(){
        $i = 1;
        foreach ($this->bookProvider() as $book) {
            \App\Book::create([
                'title' => $book[0],
                'author' => $book[1],
                'description' => $book[2],
                'isbn' => $book[3],
                'sort' => $i,
            ]);
            $i++;
        }
    }
}
