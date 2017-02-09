<?php
class MY_Loader extends CI_Loader {

	//*** TEMPLATE FOR THE ADMIN AREA ***
	//$ADMIN_LOGGED PARAMETER IS ADDED SO THE ADMIN_NAVIGATION IS LOADED ONLY WHEN ADMIN IS LOGGED_IN
    public function admin_template($template_name, $vars = array(),$admin_logged,$return = TRUE)
    {  	
        if($return):
        $content  = $this->view('templates/admin/header', $vars, $return);
        $content .= $this->view('admin/'.$template_name, $vars, $return);
		$content .= $this->view('templates/admin/footer', $vars, $return);
		echo $content;


        return $content;
    else:
        $this->view('templates/admin/header', $vars);
		$this->view($template_name, $vars);
		$this->view('templates/admin/footer', $vars);

    endif;
    }

    	//*** TEMPLATE FOR CUSTOMER PROFILE IN THE PUBLIC AREA ***
	public function profile_template($template_name, $vars = array(),$return = TRUE){

	    if($return):
	     	$content  = $this->view('templates/public/header', $vars, $return);
	     	$content .= $this->view('public/profile_navbar', $vars, $return);
	        $content .= $this->view('public/'.$template_name, $vars, $return);
	        $content .= $this->view('templates/public/footer', $vars, $return);
	        echo $content;


	        return $content;
	    else:
	        $this->view('templates/public/header', $vars, $return);
	     	$this->view('public/profile_navbar', $vars, $return);
	        $this->view('public/'.$template_name, $vars, $return);
	        $this->view('templates/public/footer', $vars, $return);

	    endif;
	}

	//*** TEMPLATE FOR THE PUBLIC AREA ***
	public function template($template_name, $vars = array(),$return = TRUE){

	    if($return):
	        $content  = $this->view('templates/public/header', $vars, $return);
	        $content .= $this->view('public/'.$template_name, $vars, $return);
	        $content .= $this->view('templates/public/footer', $vars, $return);
	        echo $content;


	        return $content;
	    else:
	        $this->view('templates/public/header', $vars);
	        $this->view('public/'.$template_name, $vars);
	        $this->view('templates/public/footer', $vars);

	    endif;
	}
}
?>