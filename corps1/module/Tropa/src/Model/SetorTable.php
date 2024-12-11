<?php
namespace Tropa\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSetInterface;

class SetorTable
{
    private $tableGateway;
    
    private $keyName = 'codigo';
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }    
    
    public function fetchAll(): ResultSetInterface
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getModel(mixed $keyValue): Setor
    {
        $rowset = $this->tableGateway->select(array(
            $this->keyName => $keyValue
        ));
        if ($rowset->count()>0){
            $row = $rowset->current();
        } else {
            $row = new Setor();
        }       
        
        return $row;
    }
    
    public function saveModel(Setor $setor): void
    {
        $data = array(
            'nome' => $setor->nome
        );
        $codigo = $setor->codigo;
        if (empty($this->getModel($codigo)->codigo)) {
            $data['codigo'] = $codigo;
            $this->tableGateway->insert($data);
        } else {
            $this->tableGateway->update($data, array(
                'codigo' => $codigo
            ));
        }
    }    
    
    public function deleteModel(mixed $keyValue): void
    {
        $this->tableGateway->delete(array(
            $this->keyName => $keyValue
        ));
    }
}    
