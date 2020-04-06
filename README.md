<h2> Welcome to Atlantico's Library! </h2>

<p>
    Here you can find some books to rent with promotional price! 
</p>

<p>
    Here we have the following routes
</p>
<ul>
    <li>
        <b>Login</b>
    </li>
    <li>
        <b>User</b>
    </li>
    <li>
        <b>Books</b>
    </li>
    <li>
        <b>Rent Books</b>
    </li>
</ul>
<h2> To start the application you have to take some steps </h2>
<ul>
    <li>
        <p>Run - sudo composer install - to install the dependencies</p>
    </li>
    <li>
        <p>Make a copy of .env.example and renamed to .env</p>
    </li>
    <li>
        <p>Set DB_* variables according to your database
       </p>
       <h4>Note: you have to create a database with same name that you set on you DB_DATABASE</h4>
    </li>
    <li>
        <p>Run - php artisan jwt:secret - to set env jwt secret or you can access .env and set JWT_SECRET with your own secret</p>
    </li>
    <li>
        <p>Run - php artisan migrate - to create all the tables</p>
    </li>
    <li>
        <p>Run - php artisan db:seed - to create an admin for your application</p>
        <p>Email: admin@atlantico.com, password: 123456</p>
    </li>
    <li>
        <p>And run - php artisan serve - </p>
    </li>
    <li>
        <p>Just make sure you have made through all the steps</p>
    </li>
</ul>
<h2>Now let's start:</h2>
<h3>
    Let's start with <b>Login</b>
</h3>
<ul>
    <li>
        <h3>'api/login' - POST</h3>
        <p>You have to enter the following JSON body:</p>
        <h4>
            {
                "username":"admin@atlantico.com",
                "password":"123456"
            }
        </h4>
        <p>The response is going to be:</p>
        <h4>
            {
              "access_token": "",
              "token_type": "",
              "expires_in": 
            }
        </h4>
        <p>From now on you'll have to use the token on your header on Authorization field:</p>
        <h4>Authorization: Bearer $token</h4>
    </li>
</ul>
<h4>Note: now you have to use auth after "api/", so all routes from now on, are going to be 'api/auth/'</h4>

<h3>
    Next one is <b>User</b>
</h3>
<ul>
    <li>
        <h3>'user' - GET</h3>
        <p>Retrieves all users:</p>
        <h4>
            {
              "data": [
                {
                  "id": 1,
                  "name": "Admin",
                  "email": "admin@atlantico.com"
                }
              ]
            }
        </h4>
        <h3>'user' - POST</h3>
        <p>Create new User:</p>
        <p>Body:</p>
        <h4>
            {
            	"name": "Matheus",
                "email": "matheusalves789@outlook.com",
            	"password": "123456"
            }
        </h4>
        <h4>Note: email field has to be unique.</h4>
        <p>Response:</p>
        <h4>
           {
             "data": {
               "id": 2,
               "name": "Matheus",
               "email": "matheusalves789@outlook.com"
             }
           }
        </h4>
        <h3>'user/$id' - PUT</h3>
        <p>Update User:</p>
        <p>Body:</p>
        <h4>
            {
                "name": "Matt",
                "email": ""
                "password":""
            }
        </h4>
        <h4>Note: you can update every field or only one.</h4>
        <p>Response:</p>
        <h4>
           {
             "data": {
               "id": 3,
               "name": "Matt",
               "email": "matheusalves789@outlook.com"
             }
           }
        </h4>
        <h3>'user/$id' - DELETE</h3>
        <p>Delete User:</p>
        <h4>
           {
            "success": "User deleted"
           }
        </h4>
    </li>
</ul>

<h3>
    Next one is <b>Book</b>
</h3>
<ul>
    <li>
        <h3>'book' - GET</h3>
        <p>Retrieves all books:</p>
        <p>Response:</p>
        <h4>
            {
              "data": [
                {
                  "id": 1,
                  "title": "Theory of everything",
                  "count": 1
                },
                {
                  "id": 2,
                  "title": "Clean Code",
                  "count": 1
                }
              ]
            }
        </h4>
        <h3>'book' - POST</h3>
        <p>Create new Book:</p>
        <p>Body:</p>
        <h4>
            {
                "title": "JavaScript for dummies"
            }
        </h4>
        <h4>Note: title field has to be unique.</h4>
        <p>Response:</p>
        <h4>
           {
             "data": {
               "id": 3,
               "title": "JavaScript for dummies",
               "count": 1
             }
           }
        </h4>
        <h3>'book/$id' - PUT</h3>
        <p>Update Book:</p>
        <p>Body:</p>
        <h4>
            {
                "title": "" OR "title":"JS for dummies"
            }
        </h4>
        <h4>Note: you can update the title or just add one more copy.</h4>
        <h4>
           {
             "data": {
               "id": 3,
               "title": "JavaScript for dummies",
               "count": 2
             }
           }
           <b>OR</b>
           {
             "data": {
               "id": 3,
               "title": "JS for dummies",
               "count": 3
             }
           }
        </h4>
        <h3>'book/$id' - DELETE</h3>
        <p>Delete Book:</p>
        <h4>
           {
            "success": "Book deleted"
           }
        </h4>
    </li>
</ul>
<h3>
    Last but no least: <b>Rent Books</b>
</h3>
<ul>
    <li>
        <h3>'rented_books' - GET</h3>
        <p>Retrieves all rented books:</p>
        <p>Response:</p>
        <h4>
            {
              "data": [
                {
                  "id": 2,
                  "user_id": 1,
                  "book_id": 1,
                  "payment_value": "R$ 4,50",
                  "rent_expiration_date": "2020-04-08",
                  "status": "paid"
                },
                {
                  "id": 3,
                  "user_id": 1,
                  "book_id": 1,
                  "payment_value": "R$ 4,50",
                  "rent_expiration_date": "2020-04-08",
                  "status": "paid"
                }
              ]
            }
        </h4>
        <h3>'rented_books' - POST</h3>
        <p>Create new Rent for a book:</p>
        <p>Body:</p>
        <h4>
            {
            	"book_id":"1",
            	"user_id":"1",
            	"payment_value":"4,50"
            }
        </h4>
        <h4>Note: if you don't pass any payment_value, the default is 3,50. The default value for rent_expiration_date is 3 days.</h4>
        <p>Response:</p>
        <h4>
           {
             "data": {
               "id": 4,
               "user_id": "1",
               "book_id": "1",
               "payment_value": "R$ 4,50",
               "rent_expiration_date": {
                 "date": "2020-04-08 18:35:52.715283",
                 "timezone_type": 3,
                 "timezone": "UTC"
               },
               "status": "ongoing"
             }
           }
        </h4>
        <h3>'book/$id' - PUT</h3>
        <p>Update Book:</p>
        <p>Body:</p>
        <h4>
            * No body needed *
        </h4>
        <h4>Note: you are just paying the book.</h4>
        <h4>
           {
             "success": "Paid the rent successfully"
           }
        </h4>
    </li>
</ul>
