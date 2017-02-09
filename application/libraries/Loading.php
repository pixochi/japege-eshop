<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loading {
    //LOAD PUBLIC JS
        public function pjs($location = [])
        {
            //FORACH IS ALREADY IN SCRIPT_TAG HELPER, ARGUMENTS MUST BE ARRAY OF SCRIPTS
            $scripts = [];
            foreach ($location as $js_name) {
                $script = base_url('assets/scripts/public/'.$js_name.'.js');
                array_push($scripts, $script);
            }
            script_tag($scripts);
        }
//LOAD PUBLIC CSS
          public function pcss($location = [])
        {
            foreach ($location as $css_name) {
               echo link_tag(base_url('assets/styles/public/'.$css_name.'.css'),'stylesheet','text/css');
            }
        }
//LOAD ADMIN CSS
          public function acss($location = [])
        {
            foreach ($location as $css_name) {
               echo link_tag(base_url('assets/styles/admin/'.$css_name.'.css'),'stylesheet','text/css');
            }
        }
        //LOAD USER IMAGE
           public function customer_img($location,$attributes = [])
        {
            echo img(base_url('assets/images/uploads/customers/'.$location), TRUE, $attributes);
        }
//LOAD PUBLIC IMAGE
          public function pimg($location,$attributes = [])
        {
            echo img(base_url('assets/images/public/'.$location), TRUE, $attributes);
        }

}

?>