<?php

namespace View;

use App\View\TemplateNotFound;

/**
 * Class Template
 * Used for parsing templates and creating HTML code
 * How to use:
 *      {# var #}                      =>      $var
 *      {? A :: condition :: B ?}      =>      if (condition) { A; } else { B; }
 *
 */
class Template {
    private const templatePath = __DIR__ . "/../Template/";
    private static string $VALID_VAR_NAME = "/^([a-zA-Z_$][a-zA-Z_$0-9]*)$/";
    private static string $VAR_PATTERN = "/{#\s*(\S+)\s*#}/";
    private static string $IF_PATTERN = "/{\?" . "(?<true>[^\:]+)" . "::(?<condition>[^\:]+)" . "::(?<false>.*[^?]*)\?}/";
    private static string $TMPL_PATTERN = "/{T\s*(\S+)\s*T}/";

    private string $template;
    private array $assignedValues;
    private array $templates;

    public function __construct($template_name) {
        $this->template = self::templatePath . $template_name . ".tmpl";
        if (!file_exists($this->template)) throw  new TemplateNotFound($template_name);
        $this->assignedValues = [];
        $this->templates = [];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Template
     */
    public function assign($key, $value) {
        $this->assignedValues[$key] = $value;
        return $this;
    }

    public function addTemplate($key, $value) {
        $this->templates[$key] = $value;
        return $this;
    }

    public function render() {
        echo $this->replace();
    }

    public function getHTML() {
        return $this->replace();
    }

    private function replace(): string {
        $if_replace = function ($matches) {

            $if_elements = array_map('trim', $matches);

            if (in_array("", $if_elements)) {
                return "{Invalid IF statement!}";
            }
            return $this->assignedValues[$if_elements['condition']] ?
                $if_elements['true'] :
                $if_elements['false'];
        };

        $var_replace = function ($matches) {
            $var_name = $matches[1];
            if (!preg_match(self::$VALID_VAR_NAME, $var_name)) {
                return "{Variable name: \"$var_name\" is invalid";
            }
            if (!isset($this->assignedValues[$var_name])) {
                return "{Missing param : " . "\"$var_name\"}";
            }
            return $this->assignedValues[$var_name];
        };

        $tmpl_replace = function ($matches) {
            $var_name = $matches[1];
            if (!preg_match(self::$VALID_VAR_NAME, $var_name)) {
                return "{Template name: \"$var_name\" is invalid";
            }
            if (!isset($this->templates[$var_name])) {
                return "";
            }

            if (is_array($this->templates[$var_name])){
                $tmpl_html = [];
                foreach ($this->templates[$var_name] as $template){
                    $tmpl_html [] = $template->getHTML();
                }
                return implode("", $tmpl_html);
            }
            else{
                return $this->templates[$var_name]->getHTML();
            }
        };

        $template = file_get_contents($this->template);
        $parsedTemplate = preg_replace_callback(self::$TMPL_PATTERN, $tmpl_replace, $template);
        $parsedTemplate = preg_replace_callback(self::$IF_PATTERN, $if_replace, $parsedTemplate);

        return preg_replace_callback(self::$VAR_PATTERN, $var_replace, $parsedTemplate);
    }
}