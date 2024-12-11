<?php
namespace Tropa\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Tropa\Form\Lanterna as LanternaForm;
use Tropa\Model\Lanterna;
use Laminas\Session\Container as SessionContainer;
use Tropa\Model\LanternaTable;
use Tropa\Model\SetorTable;
use Laminas\Session\SessionManager;
use Laminas\I18n\Translator\Translator;
use Laminas\I18n\Translator\Resources;
use Laminas\Validator\AbstractValidator;
use Laminas\Validator\Translator\Translator as ValidatorTranslator;

class LanternaController extends AbstractActionController
{
    private LanternaTable $table;
    private SetorTable $parentTable;

    public function __construct(LanternaTable $table, SetorTable $parentTable, SessionManager $sessionManager)
    {
        $this->table = $table;
        $this->parentTable = $parentTable;
        $sessionManager->start();
    }

    public function indexAction()
    {
        return new ViewModel(
            ['models' => $this->table->fetchAll()]
        );
    }
    
    /**
     * Action to add and change records
     */
    public function editAction()
    {
        $codigo = $this->params()->fromRoute('key', null);
        $lanterna = $this->table->getModel($codigo);
        $form = new LanternaForm('lanterna',['table' => $this->parentTable]);
        $form->get('submit')->setValue(
            empty($codigo) ? 'Cadastrar' : 'Alterar'
            );
        $sessionContainer = new SessionContainer();
        if (isset($sessionContainer->model)){
            $lanterna->exchangeArray($sessionContainer->model->toArray());
            unset($sessionContainer->model);
            $form->setInputFilter($lanterna->getInputFilter());
            $this->initValidatorTranslator();
            $form->bind($lanterna);
            $form->isValid();
        } else {
            $form->bind($lanterna);
        }
        return [
            'form' => $form,
            'title' => empty($codigo) ? 'Incluir' : 'Alterar'
        ];
    }
    
    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form = new LanternaForm('lanterna',['table'=>$this->parentTable]);
            $lanterna = new Lanterna();
            $form->setInputFilter($lanterna->getInputFilter());
            $post = $request->getPost();
            $form->setData($post);
            if (! $form->isValid()) {
                $sessionContainer = new SessionContainer();
                $sessionContainer->model = $post;
                return $this->redirect()->toRoute('tropa', [
                    'action' => 'edit',
                    'controller' => 'lanterna'
                ]);
            }
            $lanterna->exchangeArray($form->getData());
            $this->table->saveModel($lanterna);
        }
        return $this->redirect()->toRoute('tropa', [
            'controller' => 'lanterna'
        ]);
    }
    
    /**
     * Action to remove records
     */
    public function deleteAction()
    {
        $codigo = $this->params()->fromRoute('key', null);
        $this->table->deleteModel($codigo);
        return $this->redirect()->toRoute(
            'tropa',
            ['controller'=>'lanterna']
            );
    }
    
    protected function initValidatorTranslator()
    {
        $translator = new Translator();
        $translator->addTranslationFilePattern(
            'phparray',
            Resources::getBasePath(),
            Resources::getPatternForValidator()
        );
        $validatorTranslator = new ValidatorTranslator($translator);

        AbstractValidator::setDefaultTranslator($validatorTranslator);
    }
}                
