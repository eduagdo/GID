<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir.'/formslib.php');
require_once($CFG->dirroot.'/local/teachersconnection/tables.php');

//use in index.php
class proyect_search extends moodleform{
	function definition(){
		global $CFG, $DB;
		
		$mform =& $this->_form;
		$instance = $this->_customdata;
		
		//Search all subject
		$ramoarray = array();
		$ramos = $DB->get_records('gid_ramo');
		foreach ($ramos as $ramo){
			$ramoarray[$ramo -> id] = $ramo -> nombre;
		}
		$selectramos= $mform->addElement('select', 'ramos', get_string('choose_subject', 'local_teachersconnection'), $ramoarray);
		
		//searsh all teachers
		$profesorarray = array();
		$profesores = $DB->get_records_sql("select u.id, u.firstname, u.lastname from `mdl_role` as r
											inner join `mdl_role_assignments` as ra ON r.id = ra.roleid
											inner join `mdl_user` as u ON ra.userid = u.id 
											where r.id = 3 or r.id=4");
		
		foreach ($profesores as $profesor){	
			$profesorarray[$profesor -> id] = $profesor -> firstname.' '.$profesor -> lastname;
		}
		$selectprofesores= $mform->addElement('select', 'profesores', get_string('choose_teacher', 'local_teachersconnection'), $profesorarray);
		
		
		//searchs all years of publication
		$fechasarray = array();
		$years = array();
		$fechas = $DB ->get_records_sql("SELECT fecha_creacion FROM `mdl_gid_publicacion`
										order by fecha_creacion desc");
		foreach($fechas as $fecha){
			$YMD = $fecha -> fecha_creacion; //year month day
			$fechaarray = explode('-', $YMD); //dates array
			$years[$fechaarray[0]] = $fechaarray[0]; //years array
		}
		$year = array_unique($years);
		$selectyear= $mform->addElement('select', 'anos', get_string('choose_year', 'local_teachersconnection'), $year);
		
		//search all curses
		$cursoarray = array();
		$cursos = $DB->get_records('gid_curso');
		foreach ($cursos as $curso){
			$cursoarray[$curso -> id] = $curso -> nombre;
		}
		$selectcursos = $mform->addElement('select', 'cursos', get_string('choose_curse', 'local_teachersconnection'), $cursoarray);
		
		//searsh all types of material
		$materialarray = array();
		$materiales = $DB->get_records('gid_material');
		foreach ($materiales as $material){
			$materialarray[$material -> id] = $material -> nombre;
		}
		$selectmateriales= $mform->addElement('select', 'materiales', get_string('choose_material', 'local_teachersconnection'), $materialarray);
		//$mform->addElement('hidden', 'action', 'busqueda');
		
		
		$this->add_action_buttons(true, get_string('search', 'local_teachersconnection'));
	}
}

class proyect_update extends moodleform{
	function definition(){
		global $CFG, $DB;
		
		$maxbytes = '10485760';
		$file1 = $mform->addElement('filemanager', 'attachments', get_string('attachment', 'local_teachersconnection'), null,
				array('subdirs' => 0, 'maxbytes' => $maxbytes, 'areamaxbytes' => 10485760, 'maxfiles' => 1,));
		
		$file2 = $mform->addElement('file', 'attachment', get_string('attachment', 'local_teachersconnection'));
		
	}
}
