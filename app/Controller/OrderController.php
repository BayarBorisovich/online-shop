<?php
namespace Controller;
class OrderController
{
    public function getOrderForm()
    {
        require_once '../View/order.phtml';
    }
    public function orderRegistration()
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            $orderName =
        }
    }

}