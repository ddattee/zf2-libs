<?php
/**
 * Abstract Controller
 *
 * @category  General
 * @package   General\Controller
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

abstract class AbstractController extends AbstractActionController
{
    /**
     * Contain ViewModel
     * @var ViewModel
     */
    private $_view;

    /**
     * Attache les évènements
     *
     * @see \Zend\Mvc\Controller\AbstractController::attachDefaultListeners()
     */
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();

        $events = $this->getEventManager();
        $events->attach('dispatch', array($this, 'preDispatch'), 100);
        $events->attach('dispatch', array($this, 'postDispatch'), -100);
    }

    /**
     * Before l'action
     *
     * @param MvcEvent $exception
     *
     * @return MvcEvent
     */
    public function preDispatch(MvcEvent $exception)
    {
        return $exception;
    }

    /**
     * After l'action
     *
     * @param MvcEvent $exception
     *
     * @return MvcEvent
     */
    public function postDispatch(MvcEvent $exception)
    {
        return $exception;
    }

    /**
     * Init view model
     *
     * @param bool $reset Should it return a new ViewModel
     *
     * @return ViewModel
     */
    protected function getViewModel($reset = false)
    {
        return (!$this->_view instanceof ViewModel || $reset ? new ViewModel() : $this->_view);
    }

    /**
     * Set view model
     *
     * @return $this
     */
    protected function setViewModel(ViewModel $v)
    {
        $this->_view = $v;
        return $this;
    }

}
