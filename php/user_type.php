<?php
//Default parent class for most user subclass, no direct implication in code, provides the id and user_type.
class user_type { 
   protected $id;
   protected $user_type;
   
   function getid(){
   return $this->id;
   }
      function getusertype(){
   return $this->user_type;
   }
} 
?>