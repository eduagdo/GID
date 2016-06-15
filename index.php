<?php
require_once (dirname ( __FILE__ ) . '/../../config.php');
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->libdir . '/formslib.php');
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
	$time = usergetdate(time());
	$date = $time['year']."-".$time['mon']."-".$time['mday']." ".$time['hours'].":".$time['minutes'].":".$time['seconds'];
	echo $OUTPUT->single_button($url, get_string('search', 'local_teachersconnection'));
	$form = new publish ( null );
	echo $form->display ();
	
	if($fromform = $form->get_data ()){
		
		$record = new stdClass();
		$record -> user_id = $USER->id;
		$record -> nombre = $fromform->documentos;
		$record -> fecha_creacion = $date;
		$record -> material_id = $fromform->materiales;
		$record -> ramo_id = $fromform->ramos;
		$record -> curso_id = $fromform->cursos;
		$record -> descripcion = $fromform->description;
		$record -> clasificacion = 0;
		
		$lastinsertid = $DB->insert_record('gid_publicacion', $record, true);
		
		$draftid = file_get_submitted_draft_itemid('file');
		$usercontext = context_user::instance($USER->id);
		$fs = get_file_storage();
		$files = $fs->get_area_files($usercontext->id, 'user', 'draft', $draftid);
		$context= context_system::instance();
		foreach ($files as $uploadedfile) {
			// Save the submitted file to check if it's a PDF.
			if ($uploadedfile->get_mimetype() == 'application/pdf' || $uploadedfile->get_mimetype() == 'application/x-pdf') {
				continue;
			}
			$filename = $uploadedfile->get_filename();
			
			$filerecord = array(
					'component' => 'local_teachersconnection',
					'filearea' => 'media',
					'contextid' => $context->id,
					'itemid' => $lastinsertid,
					'filepath' => '/',
					'filename' => $filename);
			//guardo los archivos subidos, que estaban en el draf (temp) en una carpeta definitiva
			$file = $fs->create_file_from_storedfile($filerecord, $uploadedfile->get_id());
		}
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
	$url = new moodle_url('index.php', array(
			'action' => 'ver'));
	echo $OUTPUT->single_button($url, get_string('back', 'local_teachersconnection'));
	
}


echo $OUTPUT->footer (); //shows footer 