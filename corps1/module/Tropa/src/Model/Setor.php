<?php
namespace Tropa\Model;

use Laminas\InputFilter\InputFilterInterface;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\Factory;

class Setor
{
    public int $codigo = 0;

    public string $nome = '';
    
    private ?InputFilterInterface $inputFilter = null;    
    
    public function exchangeArray(array $data)
    {
        foreach($data as $attribute => $value){
            $this->$attribute = $value;
        }
    }
    
    public function getInputFilter(): InputFilterInterface
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new Factory();
            $inputFilter->add($factory->createInput([
                'name' => 'codigo',
                'required' => false,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Between',
                        'options' => [
                            'min' => 0,
                            'max' => 3600
                        ]
                    ]
                ]
            ]));
            $inputFilter->add($factory->createInput([
                'name' => 'nome',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'StripTags'
                    ],
                    [
                        'name' => 'StringTrim'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'StringLength',
                        'options' => [
                            'encoding' => 'UTF-8',
                            'min' => 2,
                            'max' => 30
                        ]
                    ]
                ]
            ]));
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }  
    
    public function getArrayCopy(): array 
    {
        return [
            'codigo'=>$this->codigo,
            'nome'=>$this->nome
        ];
    }    
}

