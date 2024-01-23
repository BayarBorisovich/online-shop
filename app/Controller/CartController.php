<?php
namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Service\Authentication\AuthenticationInterface;
use Service\Authentication\SessionAuthenticationService;

class CartController
{
    private AuthenticationInterface $authenticationService;
    public function __construct(AuthenticationInterface $authenticationService) // инъекция зависимости
    {
        $this->authenticationService = $authenticationService;
    }
    public function postAddProduct(AddProductRequest $request): string
    {
        $user = $this->authenticationService->getCurrentUser();
        if (empty($user)) {
            header('location: /login');
        }

        $errors = $request->validate();

        if (!empty($errors)) {
            header('location: /main');
        }

        $productId = $request->getBody()['product_id'];
        $quantity = $request->getBody()['quantity'];


        $cart = Cart::getOne($user->getId());
        if (!isset($cart)) {
            Cart::create($user->getId());

            $cart = Cart::getOne($user->getId());
        }
        $cartId = $cart->getId();

        CartProduct::create($cartId, $productId, $quantity);

        header('location: /main');

    }
    public function getCart(): void
    {
        $user = $this->authenticationService->getCurrentUser();
        if (empty($user)) {
            header('location: /login');
        }

        $cartProducts = CartProduct::getAllByUserId($user->getId()); // все продукты в корзине у пользователя
        if (empty($cartProducts)) {
            header('location: /main');
        }

        $products = Product::getAllByUserId($user->getId()); // продукты пользователя

        foreach ($cartProducts as $cartProduct) {
            if (isset($products[$cartProduct->getProductId()])) {
                $product = $products[$cartProduct->getProductId()];
                $sumPrice[] = $product->getPrice()*$cartProduct->getQuantity();
            }
        }
        $sumTotalCart = array_sum($sumPrice); // Общая сумма корзины;
        require_once '../View/cart.phtml';
    }
    public function deleteAnItem(AddProductRequest $request): void
    {
        $user = $this->authenticationService->getCurrentUser();
        if (empty($user)) {
            header('location: /login');
        }

        if (!isset($request->getBody()['product_id'])) {
            header('location: /main');
        }
        $productId = $request->getBody()['product_id'];

        $cartId = Cart::getOne($user->getId())->getId();

        CartProduct::removingAproduct($productId, $cartId);

        header('location: /cart');
    }
}
