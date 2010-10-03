<?php
namespace kakalika\blocks\login_info;

use ntentan\Ntentan;

use ntentan\views\blocks\Block;


class LoginInfo extends Block
{
    public function __construct()
    {
        $this->set("user", $_SESSION["user"]);
        $this->set("logout_path", Ntentan::getUrl("users/logout"));
    }
}