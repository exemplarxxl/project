<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class OrderForm extends CFormModel
{
    public $name;
    public $email;
    public $phone;
    public $body;

    /**
     * Declares the validation rules.
     */
    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('name, phone, body', 'required'),
            // email has to be a valid email address
            array('email', 'email'),

        );
    }

    public function attributeLabels()
    {
        return array(
            'name' => 'Ваше имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'body' => 'Сообщение',
        );
    }

}