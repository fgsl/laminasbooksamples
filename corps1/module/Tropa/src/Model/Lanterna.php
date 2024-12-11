<?php
namespace Tropa\Model;

use Laminas\InputFilter\Factory as InputFactory;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterInterface;

class Lanterna
{
    public int $codigo = 0;

    public string $nome = '';

    public ?Setor $setor = null;

    private ?InputFilterInterface $inputFilter = null;
    
    public function __construct()
    {
        $this->setor = new Setor();
    }
    
    public function exchangeArray(array $data)
    {
        $this->codigo = (isset($data['codigo']) ? $data['codigo'] : null);
        $this->nome = (isset($data['nome']) ? $data['nome'] : null);
        $this->setor = new Setor();
        $this->setor->codigo = (isset($data['codigo_setor']) ? $data['codigo_setor'] : 0);
        $this->setor->nome = (isset($data['setor']) ? $data['setor'] : '');
    }
    
    public function getInputFilter(): InputFilterInterface
    {
        if (! $this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
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
            $inputFilter->add($factory->createInput([
                'name' => 'codigo_setor',
                'required' => true,
                'filters' => [
                    [
                        'name' => 'Int'
                    ]
                ],
                'validators' => [
                    [
                        'name' => 'Digits'
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
            'codigo' => $this->codigo,
            'nome' => $this->nome,
            'codigo_setor' => $this->setor->codigo
        ];
    }
}        
