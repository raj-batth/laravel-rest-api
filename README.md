# Restful E-commerce API

<p align="center">
  <a href="https://laravel.com/" alt="Built with: Laravel v7.15.0">
    <img src="https://badgen.net/badge/Built%20with/Laravel%20v7.15.0/FF2D20" />
  </a>
  <a href="https://www.php.net/downloads.php" alt="Powered by: PHP v7.4.4">
    <img src="https://badgen.net/badge/Powered%20by/PHP%20v7.4.4/8892BF" />
  </a>
</p>

## Features

-   All the registered **users** are stored in the **'users'** table.
-   User can list **products** and acquire an additional role as a **seller**.
-   Users can **purchase** the **products** as a **buyer**.
-   All the user **transactions** are stored in the **'transaction'** table.
-   The **product** information is stored in the **'products'** table.
-   Each **product** belongs to a **category** listed in the **'catgories'** tables.

## LARAVEL / PHP / Other features used

-   **Custom Exception Handling**
-   **Validation and Custom Rules**
-   **Migration and Seeding**
-   **Scopes**
-   **Mutators and Accessors**
-   **Events**
-   **Soft deletes**
-   **Resources**

## Few Endpoints fro testing

| Description             | Payload                                                  | HTTP Methods |
| ----------------------- | -------------------------------------------------------- | ------------ |
| Get all users:          | http://127.0.0.1:8000/api/users                          | GET          |
| Get single user by ID:  | http://127.0.0.1:8000/api/users/{id}                     | GET          |
| Create a new user:      | http://127.0.0.1:8000/api/users                          | POST         |
| Update a user:          | http://127.0.0.1:8000/api/users/{id}                     | PUT          |
| Delete a user:          | http://127.0.0.1:8000/api/users/{id}                     | DELETE       |
| Verify a user:          | http://127.0.0.1:8000/api/users/verify/{token}           | GET          |
| Get all buyers:         | http://127.0.0.1:8000/api/buyers                         | GET          |
| Get single buyer by ID: | http://127.0.0.1:8000/api/buyers/{buyer_id}              | GET          |
| Buyer's Transaction:    | http://127.0.0.1:8000/api/buyers/{buyer_id}/transactions | GET          |
| Products bought by a buyer:    | http://127.0.0.1:8000/api/buyers/{buyer_id}/products | GET          |
| Get all sellers:         | http://127.0.0.1:8000/api/sellers                       | GET          |
| Get single seller by ID: | http://127.0.0.1:8000/api/sellers/{seller_id}              | GET          |
| Sellers's Transaction:    | http://127.0.0.1:8000/api/sellers/{seller_id}/transactions | GET          |
| Seller can create a new Product:    | http://127.0.0.1:8000/api/sellers/{seller_id}/products | POST          |
| Seller can update a Product:    | http://127.0.0.1:8000/api/sellers/{seller_id/products/{product_id} | PUT          |
| Seller can delete a Product:    | http://127.0.0.1:8000/api/sellers/{seller_id}/products/{product_id} | DELETE          |


## License

[MIT](https://choosealicense.com/licenses/mit/)
