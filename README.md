Instructions:
=============

### 1. Install all dependencies via composer ###

```
$ composer install
```

### 2. Create database and schema ###

```
$ ./bin/console doctrine:database:create
$ ./bin/console doctrine:schema:create
```

### 3. Fill database with fixtures ###

```
$ ./bin/console doctrine:fixtures:load
```

### 4. Start a Symfony server ###

```
$ ./bin/console server:run
```
### 5. Access the site on <http://localhost:8000/> ###

#### Show single book
```
/books/{id}
```

#### Add new book
```
/admin/new
```

#### Edit the book
```
/admin/edit/{id}
```

#### API endpoint to change book status
```
/api/books/{id}
```