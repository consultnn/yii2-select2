<?php

namespace consultnn\select2;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class Select2 extends InputWidget
{
    /**
     * @var array @see Html::dropDownList()
     */
    public $items = [];

    /**
     * @var array widget plugin options
     */
    public $pluginOptions = [];

    /**
     * @var array widget JQuery events. You must define events in
     * event-name => event-function format
     * for example:
     * ~~~
     * pluginEvents = [
     *      "change" => "function(e) { log('change'); }",
     *      "select2:open" => "function(e) { log('select2:open', e); }",
     *      "select2:close" => "function(e) { log('select2:close', e); }",
     *      "select2:select" => "function(e) { log('select2:select', e); }",
     *      "select2:unselect" => "function(e) { log('select2:unselect', e); }",
     * ];
     * ~~~
     */
    public $pluginEvents = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (!empty($this->options['id'])) {
            $this->setId($this->options['id']);
        }

        if (empty($this->pluginOptions['language'])) {
            $appLanguage = strtolower(substr(Yii::$app->language, 0, 2));
            if ($appLanguage !== 'en') {
                $this->pluginOptions['language'] = $appLanguage;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $this->items, $this->options);
        }

        $this->registerClientScript();
        $this->registerEvents();
    }

    /**
     * Register widget asset.
     */
    protected function registerClientScript()
    {
        $view = $this->getView();

        $asset = Select2Asset::register($view);

        if (!empty($this->pluginOptions['language'])) {
            $asset->language = $this->pluginOptions['language'];
        }

        $options = empty($this->pluginOptions) ? '' : Json::encode($this->pluginOptions);
        $js = "jQuery('#{$this->getId()}').select2({$options});";
        $view->registerJs($js);
    }

    /**
     * Register widget events.
     */
    protected function registerEvents()
    {
        if (!empty($this->pluginEvents)) {
            $js = [];
            foreach ($this->pluginEvents as $event => $handler) {
                $js[] = "jQuery('#{$this->getId()}').on('{$event}', $handler);";
            }

            $this->getView()->registerJs(implode("\n", $js));
        }
    }
}
