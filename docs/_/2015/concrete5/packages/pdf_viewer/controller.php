<?php  
namespace Concrete\Package\PdfViewer;
use Package;
use BlockType;
use Loader;

class Controller extends Package {

     protected $pkgHandle = 'pdf_viewer';
     protected $appVersionRequired = '5.7.0.4';
     protected $pkgVersion = '1.0.1';

     public function getPackageDescription() {
          return t("A Block for viewing a PDF on your page");
     }

     public function getPackageName() {
          return t("PDF Viewer");
     }
     
     public function install() {
          $pkg = parent::install();
     
          // install block 
          BlockType::installBlockTypeFromPackage('pdf_viewer', $pkg); 
     }
     
}
?>