<?php

namespace Framework\Renderer\Twig\TwigExtension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

class FormTwigExtension extends AbstractExtension{

    private $formService;

    public function getFunctions() : array
    {
        return [
            new TwigFunction('field', [$this, 'field'], [
                'is_safe' => ['html'],
                'needs_context' => true
            ])
        ];
    }


    public function field(array $context, string $key, $value, string $label, array $options = []) : string
    {
        $type = $options['type'] ?? 'text';
        $error = $this->getErrorHtml($context, $key);

        if($type == 'textarea'){
            $input = $this->textarea($key, $value);
        }
        else if($type == 'file'){
            $input = $this->file($key);
        }
        elseif (array_key_exists('options', $options)){
            $input = $this->selected($key, $value, $options['options']);
        }
        else{
            $input = $this->input($key, $value);
        }

        return "
            <div>
                <label for=\"$key\">$label</label>
                $input
                $error
            </div>
        ";
    }

    private function file(string $key)
    {
        return "<input type=\"file\" name=\"$key\" id=\"$key\">";
    }

    private function selected(string $key, $value, array $options) : string
    {
        $data = array_reduce(array_keys($options), function($text, $index) use ($options, $value) {
            $selected = $value == $index ? ' selected' : '';
            return $text . "<option value=\"$index\"$selected>{$options[$index]}</option>";
        }, '');

        return "<select name=\"$key\" id=\"$key\">$data</select>";
    }


    private function input(string $key, ?string $value = ''):string
    {
        return "<input type=\"text\" name=\"$key\" id=\"$key\" value=\"$value\">";
    }

    private function textarea($key, ?string $value = ''):string
    {
        return "<textarea type=\"text\" name=\"$key\" id=\"$key\">
                $value
            </textarea>";
    }

    private function getErrorHtml(array $context, $key)
    {
        $error = $context['errors'][$key] ?? false;

        if($error){
            return '<small class="text-red-600">'.$error.'</small>';
        }

        return '';
    }
}