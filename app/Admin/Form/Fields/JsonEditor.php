<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Admin\Form\Fields;

use Encore\Admin\Admin;
use Encore\Admin\Form\Field;

class JsonEditor extends Field
{

    public function render()
    {
        $name = $this->elementName ?: $this->formatName($this->column);
        $value = $this->value() ?: '{}';
        $editor = uniqid('JsonEditor', false);
        Admin::script(
            <<<SCRIPT
            var {$editor} = new JSONEditor(
                document.getElementById('{$name}'),
                {
                    mode: 'code',
                    onChange: function () {
                        $('[name="{$name}"]').val({$editor}.getText());
                    }
                }
            );
            {$editor}.set({$value});
SCRIPT
        );
        return view('form.fields.json', $this->variables());
    }

}
