<?php

define("DS", "/");
// Định nghĩa các đường dẫn gốc
define("ROOT_PATH", dirname(__FILE__));
define("APPLICATION_PATH", ROOT_PATH . DS . "app" . DS);
define("MODULE_PATH", APPLICATION_PATH . "module" . DS);
define("PUBLIC_PATH", ROOT_PATH . DS . "Public" . DS);
define("LIBS_PATH", ROOT_PATH . DS . "Libs" . DS);
define("TEMPLATE_PATH", PUBLIC_PATH .  "Template" . DS);

// Định nghĩa URL mặc định
define("DEFAULT_MODULE", "default");
define("DEFAULT_CONTROLLER", "index");
define("DEFAULT_ACTION", "index");

// Định nghĩa các đường dẫn tương đối 
define("ROOT_URL", "\PHP_Zend\BookStore" . DS);
define("APP_URL", ROOT_URL . "app" . DS);
define("PUBLIC_URL", ROOT_URL  . "Public" . DS);
define("TEMPLATE_URL", PUBLIC_URL . "Template" . DS);
// Định nghĩa kết nối với database
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "bookstore");
define("DB_TABLE", "grouper");
