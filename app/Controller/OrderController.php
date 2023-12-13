<?php
namespace Controller;
use Model\Order;
use Request\OrderRegistrationRequest;

class OrderController
{
    public function getOrderForm(): void
    {
        require_once '../View/order.phtml';
    }
    public function orderRegistration(OrderRegistrationRequest $request): void
    {
       $errors = $request->validate();

       if (empty($errors)) {
           if (isset($request->getBody()['name']) && isset($request->getBody()['surname']) && isset($request->getBody()['patronymic']) && isset($request->getBody()['city']) && isset($request->getBody()['street']) && isset($request->getBody()['house'])) {
               session_start();
               if (isset($_SESSION['user_id'])) {
                   $userId = $_SESSION['user_id'];
                   $name = $request->getBody()['name'];
                   $surname = $request->getBody()['surname'];
                   $patronymic = $request->getBody()['patronymic'];
                   $city = $request->getBody()['city'];
                   $street = $request->getBody()['street'];
                   $house = $request->getBody()['house'];

                   $a = Order::creatOrders($name, $surname, $patronymic, $city, $street, $house, $userId);
               } else {
                   header('location: /login');
               }
           } else {
               header('location: /cart');
           }
       }
        require_once '../View/order.phtml';
    }

}