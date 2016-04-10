<?php
/**
 * quickSelectColumns Plugin for LimeSurvey
 *
 * @author Denis Chenu <denis@sondages.pro>
 * @copyright 2014-2015 Ysthad
 * @copyright 2014-2016 Denis Chenu <http://sondages.pro>
 * @license AGPL v3
 * @version 0.1
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 */
#use ls\pluginmanager\PluginBase;
class quickSelectColumns extends PluginBase {
  //protected $storage = 'DbStorage';
  static protected $description = 'Quicik select of column in export.';
  static protected $name = 'quickSelectColumns';

  public function init()
  {
    $this->subscribe('afterPluginLoad');
    //$this->subscribe('newDirectRequest'); @todo : allow to save in ajax

  }

  public function afterPluginLoad()
  {
    // Control if we are in an admin page, register everywhere even is not needed
    $oRequest=$this->pluginManager->getAPI()->getRequest();
    $sController=Yii::app()->getController()->getId();
    if($sController=='admin')
    {
      $sAction=$this->getParam('sa');
      if($sAction=='exportresults')
      {
        $iSurveyId = Yii::app()->request->getParam('surveyid');
        $sExportType = Yii::app()->request->getPost('type');
        if(!$sExportType)
          $this->showColumnsSelect();
        //~ else
          //~ $this->addFilters($iSurveyId);
      }
    }
  }

  /**
   *
   *
   */
  private function showColumnsSelect()
  {
    Yii::app()->getClientScript()->registerScriptFile(Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/quickcolumnselect.js"),CClientScript::POS_END);
    Yii::app()->getClientScript()->registerCssFile(Yii::app()->assetManager->publish(dirname(__FILE__)."/assets/quickcolumnselect.css"));

  }

  private function getParam($sParam,$default=null)
  {
      $oRequest=$this->pluginManager->getAPI()->getRequest();
      if($oRequest->getParam($sParam))
          return $oRequest->getParam($sParam);
      $sController=Yii::app()->getUrlManager()->parseUrl($oRequest); // This don't set the param according to route always : TODO : fix it (maybe neede $routes ?)
      $aController=explode('/',$sController);
      if($iPosition=array_search($sParam,$aController))
          return isset($aController[$iPosition+1]) ? $aController[$iPosition+1] : $default;
      return $default;
  }
}
