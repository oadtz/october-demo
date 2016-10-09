<?php namespace Radiantweb\Problog\FormWidgets;

use URL;
use Backend\Classes\FormWidgetBase;
use Radiantweb\Problog\Models\Settings as ProblogSettingsModel;

/**
 * Optimizer SEO Tool
 *
 * @package radiantweb\problog
 * @author ChadStrat
 */
class Optimizer extends FormWidgetBase
{

    /**
     * {@inheritDoc}
     */
    public function init()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('optimizer');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $settings = ProblogSettingsModel::instance();
        $this->vars['alchemy'] = $settings->get('alchemy');
        $this->vars['checkUrl'] = URL::to('/radiantweb_api/problog/check_url/valid/');
        $this->vars['checkUrlXmlrpc'] = URL::to('/radiantweb_api/problog/check_url/valid_link/');
    }

    /**
     * {@inheritDoc}
     */
    public function loadAssets()
    {
        $this->addCss('css/font-awesome.css');
        $this->addCss('css/seo_tools.css');
        $this->addJs('../../../../../../modules/backend/formwidgets/richeditor/assets/vendor/redactor/redactor.js');
        $this->addJs('js/seo_tools.js');
    }

    /**
    * Process the postback data for this widget.
    * @param $value The existing value for this widget.
    * @return string The new value for this widget.
    */
    public function getSaveValue($value)
    {

    }


}
