<?php 

class Message 
{
    private ?int $id=null;
    
    public function __construct (private string $content, private timestamp $timestamp)
    {
        
    }
    
   public function getId() :?int
    {
        return $this->id;
    }
    
    public function setId($id) :void
    {
        $this->id = $id;
    }


    public function getContent() :string
    {
        return $this->content;
    }
    
    public function setContent($content) :void
    {
        $this->content = $content;
    }

    public function getTimestamp() :timestamp
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) :void
    {
        $this->timestamp = $timestamp;
    }
}