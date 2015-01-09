<?php
require_once "bc/LoginCtrl.php";

// Takes three arguments: last attempted username, the authorization
// status, and the Auth object. 
// We won't use them in this simple demonstration -- but you can use them
// to do neat things.
function loginFunction($username = null, $status = null, &$auth = null)
{
    /*
     * Change the HTML output so that it fits to your
     * application.
     */
//    echo "<form method=\"post\" action=\"index.php\">";
//    echo "<input type=\"text\" name=\"username\">";
//    echo "<input type=\"password\" name=\"password\">";
//    echo "<input type=\"submit\">";
//    echo "</form>";
	
	
		
    echo "<form method=\"post\" action=\"index.php\">";
    echo '    <center><br /><br /><br /><br />';
    echo '            <table class="image_login"><tr><td><img src="http://www.syntagma.com.ar/images/c_name.gif"></td></tr></table>';
    echo '            <table class="table_login">';
    echo '                    <tr>';
    echo '                            <td class="head_login" colspan=2>Por favor ingrese su Nombre de Usuario y su Contrase&ntilde;a</td>';
    echo '                    </tr>';
//    echo "                    <form action="/CMD_LOGIN" method="POST" name="form">";
    echo '                    <input type=hidden name=referer value="/" />';
    echo '                    <tr>';
    echo '                            <td class="text_login">Usuario:</td>';
    echo '                            <td class="data_login"><input type=text name=username size=26 /></td>';
    echo '                    </tr>';
    echo '                    <tr>';
    echo '                            <td class="text_login">Contrase&ntilde;a:</td>';
    echo '                            <td class="data_login"><input type=password name=password size=26 /></td>';
    echo '                    </tr>';
    
    echo '                    <tr>';
    echo '                            <td class="text_login">Empresa:</td>';
    echo '                            <td class="data_login"><select name=empresa>';
    echo 'Hacemos el new loginctrl';
    
    $loginCtrl = new LoginCtrl();
    //echo ('Hacemos el get empresas');
    $empresas = $loginCtrl->getEmpresas();
    
    foreach($empresas as $empresa) {
    	$selected = "";
    	if ($empresa['id_empresa'] == GLOBAL_EMPRESA) {
    		$selected = "selected";
    	}
    	
    	$nombre = $empresa['nombre'];
    	$id = $empresa['id_empresa'];
    	echo "<option $selected value='$id'>$nombre</option>";
    	
    }
    echo "</td>";
    
    echo '                    </tr>';
    
    echo '                    <tr>';
    echo '                            <td colspan=2><hr></td>';
    echo '                    </tr>';
    
    echo '                    <tr>';
    echo '                            <td class="text_login">Tema:</td>';
    echo '                            <td class="data_login"><select name=tema>';
    
	if ($handle = opendir('css')) {
    /* This is the correct way to loop over the directory. */
    	while (false !== ($file = readdir($handle))) {
    		$selected = "";
    		
    		if ($file == GLOBAL_THEME) $selected = "selected";
    		
       		if (($file != '.') && ($file != '..') && (substr($file,0,1) != "."))
			{
				echo "  							<OPTION $selected>$file</OPTION>";
			}
    	}

    	closedir($handle);
	}
	echo ' 							  </select></td>';
    echo '                    </tr>';
    
    
    echo '                    <tr>';
    echo '                            <td class="text_login">Idioma:</td>';
    echo '                            <td class="data_login"><select name=idioma>';
	if ($handle = opendir('ui/translator')) {
    /* This is the correct way to loop over the directory. */
    	while (false !== ($file = readdir($handle))) {
    		
    		$selected = "";
    		if ($file == GLOBAL_THEME) $selected = "selected";
    		
       		if (($file != '.') && ($file != '..') && (substr($file,0,1) != ".") && ($file != "Translator.php"))
			{
				echo "  							<OPTION $selected>$file</OPTION> ";
			}
    	}

    	closedir($handle);
	}
	echo ' 							  </select></td>';
    echo '                    </tr>';
    
    
    echo '                    <tr>';
    echo '                            <td class="send_login" colspan=2><button type=submit>Login</button></td>';
    echo '                    </tr>';
    echo '                    </form>';
    echo '            </table>';
    echo '    </center>';
	echo "</form>";
	
}

function logoutFunction($username = null, &$auth = null) {
	echo "<div class='mensaje'>".Translator::getTrans("SESSION_FINALIZADA")."</div>";
	//muestro un link para volver al login
	//PantallaSingleton::linkInicio();
	
	unset($_SESSION['user']);
	loginFunction();

}

function loginFailedFunction($username = null, &$auth = null) {
	echo "<div class='mensaje'>".Translator::getTrans("LOGIN_FAILED")."</div>";
}

$oLoginCtrl = null;
$oAuth = null;

class LoginSingleton {
	public function getLoginCtrl() {
		if($oLoginCtrl == null) $oLoginCtrl = new LoginCtrl();
		return $oLoginCtrl;
	}
	
	public function getAuth() {
		if($oAuth == null) {
			$oAuth = LoginSingleton::getLoginCtrl()->getAuth("loginFunction");
			$oAuth->setLogoutCallback("logoutFunction");
			$oAuth->setFailedLoginCallback("loginFailedFunction");
		}
		return $oAuth;
	}
}

//print_r($oAuth->listUsers());

//$oLoginCtrl = new LoginCtrl();
//$oAuth = $oLoginCtrl->getAuth("loginFunction");
//print_r($oAuth);

//ini_set('display_errors', 0);
LoginSingleton::getAuth()->start();
//ini_set('display_errors', 1);
?>