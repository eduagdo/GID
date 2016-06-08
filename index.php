<?php
require_once (dirname ( __FILE__ ) . '/../../config.php');
require_once($CFG->dirroot.'/local/teachersconnection/forms.php');
require_once($CFG->dirroot.'/local/teachersconnection/tables.php');
global $DB, $USER, $CFG, $OUTPUT;
require_login ();
$baseurl = new moodle_url ( '/local/teachersconnection/index.php' ); // clase pagina
$context = context_system::instance ();
$PAGE->set_context ( $context );
$PAGE->set_url ( $baseurl );
$PAGE->set_pagelayout ( 'standard' );
$PAGE->set_title ( get_string ( 'pluginname', 'local_teachersconnection' ) );
$PAGE->set_heading ( get_string ( 'title', 'local_teachersconnection' ) );
$PAGE->navbar->add ( get_string ( 'title', 'local_teachersconnection' ) );

//rescatamos el ACTION, pueden ser: ver, agregar, doc
$action = optional_param('action', 'ver', PARAM_ACTION);

echo $OUTPUT->header ();


if($action == 'ver'){
	echo $OUTPUT->heading ( get_string ( 'searcher', 'local_teachersconnection' ) );
	$url = new moodle_url('index.php', array(
			'action' => 'agregar'));
	echo $OUTPUT->single_button($url, get_string('publish', 'local_teachersconnection')).' '.$action;
	$form_search = new proyect_search ( null );
	echo $form_search->display ();
	
	if($fromform = $form_search->get_data ()){
		$subject = $fromform->ramos;
		$teacher = $fromform->profesores;
		$year = $fromform->anos;
		$curse = $fromform->cursos;
		$material = $fromform->materiales;
		
		$tablabusqueda = tablas::datosBusqueda($subject, $teacher, $year, $curse, $material);
		
		if($tablabusqueda->data){
			echo html_writer::table($tablabusqueda);
		}else{
			echo get_string ( 'error_seach', 'local_teachersconnection' );
		}
	}
}


elseif($action == 'agregar'){
	echo $OUTPUT->heading ( get_string ( 'publish', 'local_teachersconnection' ) );
	$url = new moodle_url('index.php', array(
			'action' => ' ver'));
	echo $OUTPUT->single_button($url, get_string('search', 'local_teachersconnection')).' '.$action;
	$form = new publish ( null );
	echo $form->display ();
	
	if($fromform = $form->get_data ()){
		echo $fromform->file;
		$form->save_stored_file();
	}
}

elseif($action == 'doc'){
	$id = $_POST['id'];
	
	$tabla = tables::datosDoc($id);
	
	if($tabla->data){
		echo html_writer::table($tabla);
	}else{
		echo get_string ( 'error_seach', 'local_teachersconnection' );
	}
}


echo $OUTPUT->footer (); //shows footer 