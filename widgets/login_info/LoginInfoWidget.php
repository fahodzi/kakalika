<?php
namespace kakalika\widgets\login_info;

use ntentan\Ntentan;

use ntentan\views\widgets\Widget;


class LoginInfoWidget extends Widget
{
    public function __construct()
    {
        $this->set("user", $_SESSION["user"]);
        $this->set("logout_path", Ntentan::getUrl("users/logout"));
    }
}