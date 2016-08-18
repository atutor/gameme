<?php

namespace gamify\PHPGamification\Model;

/**
 * Created by PhpStorm.
 * User: TiagoGouvea
 * Date: 08/08/15
 * Time: 11:31
 */
class Badge extends Entity
{
    protected $id;
    protected $alias;
    protected $title;
    protected $description;
    protected $imageUrl;

    public function __construct($stdClass=null){
        if ($stdClass)
            $this->fillAtributes($stdClass, $this);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAlias()
    {
        return $this->alias;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }
}