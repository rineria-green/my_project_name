<?php


namespace App\Service;


use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

class Jsoner
{
    public function getJson($data)
    {
        $serializerContext = SerializationContext :: create () -> setSerializeNull ( true );
        $serializer = SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($data, 'json', $serializerContext);
        return $jsonContent;
    }
}