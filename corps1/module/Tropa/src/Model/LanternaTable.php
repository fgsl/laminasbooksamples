<?php
namespace Tropa\Model;

use Laminas\Db\TableGateway\TableGatewayInterface;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Select;

class LanternaTable
{
    private TableGatewayInterface $tableGateway;
    
    private string $keyName = 'codigo';
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(): ResultSetInterface
    {
        $select = new Select();
        $select->from('lanterna')
        ->columns(array('codigo','nome'))
        ->join(array('s'=>'setor'), 'lanterna.codigo_setor = s.codigo',
            array('setor'=>'nome'));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }
    
    public function getModel(mixed $keyValue): Lanterna
    {
        $select = new Select();
        $select->from('lanterna')
        ->columns(array('codigo','nome','codigo_setor'))
        ->join(array('s'=>'setor'), 'lanterna.codigo_setor = s.codigo',
            array('setor'=>'nome'))
            ->where(array('lanterna.codigo' => $keyValue));
        $rowset = $this->tableGateway->selectWith($select);
        
        if ($rowset->count()>0){
            $row = $rowset->current();
        } else {
            $row = new Lanterna();
        }       
        
        return $row;
    }
    
    public function saveModel(Lanterna $lanterna): void
    {
        $data = array(
			'nome' => $lanterna->nome,
			'codigo_setor' => $lanterna->setor->codigo
        );
        $codigo = $lanterna->codigo;
        if (empty($this->getModel($codigo)->codigo)) {
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
