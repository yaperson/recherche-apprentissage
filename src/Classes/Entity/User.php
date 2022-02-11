<?php
namespace App\Classes\Entity;

class User {

    public $_id ;
    public $_email ;
    public $_password ;
    public $_role ;

    public function __construct(array $ligne)
    {
        $this->hydrate($ligne);
    }

    public function hydrate(array $ligne)
    {
        foreach($ligne as $key => $value){
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value); // on appel une methode qui est dans la variable donc on ajoute un $
            }
        }
    }
    public function __toString():string
    {
        return $this->getEmail();
    }


    /**
     * Get the value of _id
     */ 
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set the value of _id
     *
     * @return  self
     */ 
    public function setUser_id($_id)
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * Get the value of _email
     */ 
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * Set the value of _email
     *
     * @return  self
     */ 
    public function setUser_mail($_email)
    {
        $this->_email = $_email;

        return $this;
    }

    /**
     * Get the value of _password
     */ 
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Set the value of _password
     *
     * @return  self
     */ 
    public function setPassword($_password)
    {
        $this->_password = password_hash($_password, PASSWORD_BCRYPT);

        return $this;
    }


    /**
     * Get the value of _role
     */ 
    public function getUser_role()
    {
        return $this->_role;
    }

    /**
     * Set the value of _role
     *
     * @return  self
     */ 
    public function setUser_role($_role)
    {
        $this->_role = $_role;

        return $this;
    }
}

?>