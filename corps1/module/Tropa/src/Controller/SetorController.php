<?php

declare(strict_types=1);

namespace Tropa\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Tropa\Model\SetorTable;
use Tropa\Form\Setor as SetorForm;
use Tropa\Model\Setor;
use Laminas\Session\Container as SessionContainer;
use Laminas\Session\SessionManager;
use Laminas\I18n\Translator\Translator;
use Laminas\I18n\Translator\Resources;
use Laminas\Validator\AbstractValidator;
use Laminas\Validator\Translator\Translator as ValidatorTranslator;

class SetorController extends AbstractActionController
{
    private SetorTable $table;

    public function __construct(SetorTable $table, SessionManager $sessionManager)
    {
        $this->table = $table;
        $sessionManager->start();
    }

    public function indexAction()
    {
        return new ViewModel(
            ['models' => $this->table->fetchAll()]
        );
    }	
    
     /**
     * Action to add/edit and change records
     */
    public function editAction()
    {
        $codigo = $this->params()->fromRoute('key', null);
        $setor = $this->table->getModel($codigo);
        $form = new SetorForm();
        $form->get('submit')->setValue(
            empty($codigo) ? 'Cadastrar' : 'Alterar'
            );
        $sessionContainer = new SessionContainer();
        if (isset($sessionContainer->model)){
            $setor->exchangeArray($sessionContainer->model->toArray());
            unset($sessionContainer->model);
            $form->setInputFilter($setor->getInputFilter());
            $this->initValidatorTranslator();
        }
        $form->bind($setor);
        $form->isValid();
        return ['form' => $form];
    }

    /**
     * Action to save a record
     */
    public function saveAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form = new SetorForm();
            $setor = new Setor();
            $form->setInputFilter($setor->getInputFilter());
            $post = $request->getPost();
            $form->setData($post);
            if (!$form->isValid()) {
                $sessionContainer = new SessionContainer();
                $sessionContainer->model = $post;
                return $this->redirect()->toRoute(
                    'tropa',
                    [
                        'action'=>'edit',
                        'controller'=>'setor'
                    ]
                    );
                
            }
            $setor->exchangeArray($form->getData());
            $this->table->saveModel($setor);
        }
        return $this->redirect()->toRoute(
            'tropa',
            ['controller'=>'setor']
            );
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
            ['controller'=>'setor']
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
