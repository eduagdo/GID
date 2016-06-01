<?php
defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir.'/formslib.php');
class tablas{
	public static function datosBusqueda($subject, $teacher, $year, $curse, $material){
		global $DB;
		
		$tabla = new html_table();
		$tabla->head = array(get_string('document', 'local_teachersconnection'), 
				get_string('author', 'local_teachersconnection'),
				get_string('subject', 'local_teachersconnection'),
				get_string('year', 'local_teachersconnection'),
				get_string('curse', 'local_teachersconnection'),
				get_string('choose_material', 'local_teachersconnection'),
				get_string('calification', 'local_teachersconnection'),
				get_string('description', 'local_teachersconnection'));
		
		$rasultados = $DB->get_records_sql("SELECT p.nombre as 'document', u.firstname, p.fecha_creacion as 'year',  (select nombre from `mdl_gid_curso` as c where c.id = p.curso_id) as curso, r.nombre as 'subject', m.nombre as 'material', p.clasificacion, p.descripcion 
											FROM `mdl_gid_publicacion` as p
											INNER JOIN `mdl_gid_ramo`as r ON p.ramo_id = r.id
											INNER JOIN `mdl_gid_material` as m ON p.material_id = m.id
											INNER JOIN `mdl_user` as u ON p.user_id = u.id");
		foreach ($rasultados as $resultado){
			$tabla->data[]=array($resultado->document,
								$resultado->firstname,
								$resultado->subject,
								$resultado->year,
								$resultado->curso,
								$resultado->material,
								$resultado->clasificacion,
								$resultado->descripcion);
		}
		return $tabla;
		
	}
}