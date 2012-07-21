<?php

/**
 * tOpengraphMetaPlugin configuration.
 *
 * @package     tOpengraphMetaPlugin
 * @subpackage  config
 * @author      Your name here
 * @version     SVN: $Id: PluginConfiguration.class.php 17207 2009-04-10 15:36:26Z Kris.Wallsmith $
 */
class tOpengraphMetaPluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0-DEV';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $this->dispatcher->connect('response.method_not_found', array($this, 'listenToResponseMethodNotFound'));
    $this->dispatcher->connect('context.load_factories', array($this, 'loadTemplateHelper'));
  }

  public function loadTemplateHelper()
  {
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('OGMeta'));
  }

  /**
   * Listener method for the method_not_found event
   * Calls the getServiceContainer() method
   *
   * @return boolean
   */
  public function listenToResponseMethodNotFound($event)
  {
    if ('getOGMetas' == $event['method'])
    {
        $meta = array();
        $module = sfContext::getInstance()->getModuleName();
        $action = sfContext::getInstance()->getActionName();
        $config = sfConfig::get('app_tOpengraphMeta_config', array());
        if (isset($config[$module][$action]))
        {
            $meta = $config[$module][$action]['meta'];
        }
        $event->setReturnValue($meta);
        return true;
    }

    return false;
  }

  public function getHelper()
  {
      return new OGHelper();
  }
}
