<?php
namespace Request;
class OrderRegistrationRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        if (isset($this->body['telephone'])) {
            $telephone = $this->body['telephone'];
           if (empty($telephone)) {
               $errors['telephone'] = 'Заполните поле telephone';
           }
        } else {
            $errors['telephone'] = 'Заполните поле telephone';
        }
        if (isset($this->body['city'])) {
            $city = $this->body['city'];
            if (empty($city)) {
                $errors['city'] = 'Заполните поле city';
            }
        } else {
            $errors['city'] = 'Заполните поле city';
        }
        if (isset($this->body['street'])) {
            $street = $this->body['street'];
            if (empty($street)) {
                $errors['street'] = 'Заполните поле street';
            }
        } else {
            $errors['street'] = 'Заполните поле street';
        }
        if (isset($this->body['house'])) {
            $house = $this->body['house'];
            if (empty($house)) {
                $errors['house'] = 'Заполните поле house';
            }
        } else {
            $errors['house'] = 'Заполните поле house';
        }
        return $errors;
    }

}