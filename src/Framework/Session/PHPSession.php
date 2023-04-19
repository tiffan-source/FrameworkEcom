<?php

namespace Framework\Session;

use ArrayAccess;
use Framework\Session\SessionInterface;

class PHPSession implements SessionInterface, ArrayAccess
{
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();

        if(array_key_exists($key, $_SESSION))
        {
            return $_SESSION[$key];
        }

        return $default;
    }

    public function set(string $key, $value):void
    {
        $this->ensureStarted();

        $_SESSION[$key] = $value;
    }

    public function delete(string $key):void
    {
        $this->ensureStarted();

        unset($_SESSION[$key]);
    }

    private function ensureStarted()
    {
        if(session_status() == PHP_SESSION_NONE)
            session_start();
    }

    public function offsetExists($offset)
    {
        $this->ensureStarted();
        return array_key_exists($offset, $_SESSION);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);        
    }

    public function offsetUnset($offset)
    {
        $this->delete($offset); 
    }
}