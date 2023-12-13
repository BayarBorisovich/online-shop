<?php
namespace Request;
class OrderRegistrationRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        if (isset($this->body['name'])) {
           $name = $this->body['name'];
           if (empty($name)) {
               $errors['name'] = 'Заполните поле name';
           }
        } else {
            $errors['name'] = 'Заполните поле name';
        }
        if (isset($this->body['surname'])) {
            $surname = $this->body['surname'];
            if (empty($surname)) {
                $errors['surname'] = 'Заполните поле surname';
            }
        } else {
            $errors['surname'] = 'Заполните поле surname';
        }
        if (isset($this->body['patronymic'])) {
            $patronymic = $this->body['patronymic'];
            if (empty($patronymic)) {
                $errors['patronymic'] = 'Заполните поле patronymic';
            }
        } else {
            $errors['patronymic'] = 'Заполните поле patronymic';
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