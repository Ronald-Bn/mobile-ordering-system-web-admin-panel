<?php
class GetandSet
{

    public $cartId;
    public $users_id;

    public function getCartId()
    {
        return $this->cartId;
    }
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
    }

    public function getUsers_Id()
    {
        return $this->cartId;
    }
    public function setUsers_Id($users_id)
    {
        $this->users_id = $users_id;
    }
}
