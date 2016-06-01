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

//rescatamos el ACTION, pueden ser: ver, busqueda
$action = optional_param('action', 'ver', PARAM_ACTION);

echo $OUTPUT->header ();
echo $OUTPUT->heading ( get_string ( 'searcher', 'local_teachersconnection' ) );


//if($action == 'ver'){
	echo $action."<br>";
	$form_search = new proyect_search ( null );
	echo $form_search->display ();
	
	echo $context->id;
	
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
	
	
	
	
//}
/*
else if($action == 'busqueda'){
	//echo $fromform->ramos."<br>";
	//echo $fromform->profesores."<br>";
	echo $action;
}*/

/*
query para buscar todas las publicaciones

SELECT p.nombre as 'document', u.firstname, p.fecha_creacion as 'year', r.nombre as 'subject', m.nombre as 'material', p.clasificacion, p.descripcion FROM `mdl_gid_publicacion` as p
INNER JOIN `mdl_gid_ramo`as r ON p.ramo_id = r.id
INNER JOIN `mdl_gid_material` as m ON p.material_id = m.id
inner join `mdl_user` as u ON p.user_id = u.id


$email = $USER->email;

//Display search form
$form_search = new proyect_search ( null );
echo $form_search->display ();

$fromform = $form_search->get_data ();

echo $fromform->ramos;
*/
echo $OUTPUT->footer (); //shows footer 