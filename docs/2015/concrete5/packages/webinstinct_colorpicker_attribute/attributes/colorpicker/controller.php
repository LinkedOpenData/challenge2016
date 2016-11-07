<?php 
namespace Concrete\Package\WebinstinctColorpickerAttribute\Attribute\Colorpicker;

use Loader;
use View;
use Concrete\Core\Backup\ContentExporter;
use Concrete\Core\Backup\ContentImporter;
use \Concrete\Core\Attribute\Controller as AttributeTypeController;

class Controller extends AttributeTypeController
{
	protected $searchIndexFieldDefinition = array('type' => 'text', 'options' => array('length' => 4294967295, 'default' => null, 'notnull' => false));

    public function getValue()
    {
        $db = Loader::db();
        return $db->GetOne("select color from atColorpicker where avID = ?", array($this->getAttributeValueID()));
    }
    
    public function form()
    {
        $fm = Loader::helper('form');
        $form = '<div class="ccm-attribute ccm-attribute-colorpicker">';
        $this->htmlOutput($this->getValue());
        $form .= '</div>';
        print $form;
    }

	public function saveValue($color) {
		$db = Loader::db();
		$db->Replace('atColorpicker', array('avID' => $this->getAttributeValueID(), 'color' => $color), 'avID', true);
	}

	public function saveForm($data) {
		$this->saveValue($data['value']);
	}
	
	public function deleteValue() {
		$db = Loader::db();
		$db->Execute('delete from atColorpicker where avID = ?', array($this->getAttributeValueID()));
	}
    
    /**
     * This is code from Form/Service/Widget/Color
     * jQuery needs to grab the ID, which is the same as the name
     * but the name as brackets (akID[12][value]) which screws up the jQuery selector
     * so we output our own here, removing the brackets from the ID
     **/
    public function htmlOutput($value="",$options = array()) {
        $view = View::getInstance();
        $view->requireAsset('core/colorpicker');
        $form = Loader::helper('form');


        /** our hack **/
        $inputName = $this->field('value');
        $inputNameForID = str_replace("[","",$inputName);
        $inputNameForID = str_replace("]","",$inputNameForID);

        $strOptions = '';
        $i = 0;
        $defaults = array();
        $defaults['value'] = $value;
        $defaults['className'] = 'ccm-widget-colorpicker';
        $defaults['showInitial'] = true;
        $defaults['showInput'] = true;
        $defaults['allowEmpty'] = true;
        $defaults['cancelText'] = t('Cancel');
        $defaults['chooseText'] = t('Choose');
        $defaults['preferredFormat'] = 'rgb';
        $defaults['showAlpha'] = false;
        $defaults['clearText'] = t('Clear Color Selection');
        $defaults['appendTo'] = '.ui-dialog';
        $strOptions = json_encode(array_merge($defaults, $options));


        print "<input type=\"text\" name=\"{$inputName}\" value=\"{$value}\" id=\"ccm-colorpicker-{$inputNameForID}\" />";
        print "<script type=\"text/javascript\">";
        print "$(function () { $('#ccm-colorpicker-{$inputNameForID}').spectrum({$strOptions}); })";
        print "</script>";        
    }
}
