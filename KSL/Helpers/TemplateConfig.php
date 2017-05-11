<?php
/**
 * Used to store config settings of templates. 
 * Every show*() method in controller should call a method that returns
 * instance of this class and use it to create html output with Twig
 */
namespace KSL\Helpers;

class TemplateConfig {
    public $file        = null;
    public $variables   = null;

    public function __construct($file, array $variables) {
        $this->file         = $file;
        $this->variables    = $variables;
    }

    public function isValid() {
        return is_string($this->file)
            && is_array($this->variables)
            && array_key_exists('navigationSwitch', $this->variables);
    }
}