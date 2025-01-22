
# Deployment Instructions  

Follow these steps to build and deploy the services in the **payment-project**.  

## Prerequisites  

- Docker installed and configured.  
- Kubernetes cluster set up (e.g., Minikube).  
- kubectl configured to interact with your Kubernetes cluster.  

---  

## Step 1: Build Docker Images  

1. **Order Service**  
   Navigate to the `order-service` directory and build the Docker image:  
   ```bash  
   cd order-service  
   docker build -t order-service .  
   ```  

2. **User Service**  
   Navigate to the `user-service` directory and build the Docker image:  
   ```bash  
   cd user-service  
   docker build -t user-service .  
   ```  

---  

## Step 2: Deploy to Kubernetes  

From the root directory of the `payment-project`, apply the Kubernetes deployment files in the following order:  

```bash  
cd payment-project  
kubectl apply -f mysql-deployment.yaml  
kubectl apply -f redis-service.yaml
kubectl apply -f redis-deployment.yaml  
kubectl apply -f order-service-deployment.yaml  
kubectl apply -f user-service-deployment.yaml  
```  

---  

## Step 3: Access the Services  

1. **User Service**  
   To retrieve the URL for the User Service, run:  
   ```bash  
   minikube service user-service --url  
   ```  

2. **Order Service**  
   To retrieve the URL for the Order Service, run:  
   ```bash  
   minikube service order-service --url  
   ```  

---  

## User Service API Routes  

The `user-service` exposes the following API endpoints:  

### Public Routes  

- **Register a new user**  
  `POST /api/register`  
  Controller: `UserController@register`  
  **Request Body**:  
  ```json  
  {  
    "name": "david1",  
    "email": "aaaaassdsssdddsddd@test.com",  
    "password": "12345678"  
  }  
  ```

- **Login**  
  `POST /api/login`  
  Controller: `UserController@login`  
  Named Route: `login`  
  **Request Body**:  
  ```json  
  {  
    "email": "test2@test.com",  
    "password": "12345678"  
  }  
  ```  
  **Response**:  
  The login will return a bearer token that can be used to authenticate requests to the `order-service`. The response will look like:  
  ```json  
  {  
    "token": "your_bearer_token_here"  
  }  
  ```

### Protected Routes  

- **List all users**  
  `GET /api/users`  
  Controller: `UserController@index`  

---

## Order Service API Routes  

The `order-service` exposes the following API endpoints:  

### Protected Routes  

To access the protected routes in the `order-service`, include the bearer token received from the login endpoint in the **Authorization** header of your requests. The header should look like the following:  

```
Authorization: Bearer <your_bearer_token_here>
```

- **List all orders**  
  `GET /api/orders`  
  Controller: `OrderController@index`  

- **Create a new order**  
  `POST /api/orders`  
  Controller: `OrderController@store`  
  **Request Body**:  
  ```json  
  {  
    "user_id": 1,  
    "product_name": "Smartphone",  
    "status": "pending",  
    "total_amount": 900.99,  
    "shipping_address": "1234 Elm Street, Springfield, IL"  
  }  
  ```

- **Update an existing order**  
  `PUT /api/orders/{id}`  
  Controller: `OrderController@update`  
  **Request Body**:  
  (Same format as `POST /api/orders`)  
  ```json  
  {  
    "user_id": 1,  
    "product_name": "Smartphone",  
    "status": "pending",  
    "total_amount": 900.99,  
    "shipping_address": "1234 Elm Street, Springfield, IL"  
  }  
  ```

- **Delete an order**  
  `DELETE /api/orders/{id}`  
  Controller: `OrderController@destroy`  

---