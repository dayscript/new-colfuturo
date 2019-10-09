<?php
/**
 * @file
 * Contains \Drupal\event_brite\Controller\EventBrideController.
 */
namespace Drupal\event_brite\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
 
class EventBriteController extends ControllerBase {

  public function getWebhooks() {
  	/*$payload = $request->getContent();
  	dpm($payload);*/
  }

  public function content() {
  	/*$events = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?token=4Y2ZJL5AREIS7R5BWABK');
	$events = json_decode($events)->events;*/
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello world'),
    );
  }

  public function getEventsToEventBrite(){
  	$data = [];
	$date = strtotime(str_replace(' ','T',date("Y-m-d h:m:s")).'Z');
	$categories = [
		'120'=>'Actividades escolares',
		'119'=>'Aficiones e intereses especiales',
		'105'=>'Artes escénicas y visuales',
		'102'=>'Ciencia y tecnología',
		'104'=>'Cine, medios de comunicación y entretenimiento',
		'118'=>'Coches, barcos y aviones',
		'113'=>'Comunidad y cultura',
		'108'=>'Deportes y salud',
		'116'=>'Días de fiesta',
		'115'=>'Familia y educación',
		'110'=>'Gastronomía',
		'112'=>'Gobierno y política',
		'117'=>'Hogar y estilo de vida',
		'106'=>'Moda y belleza',
		'103'=>'Música',
		'101'=>'Negocios y servicios profesionales',
		'111'=>'Organizaciones y causas benéficas',
		'199'=>'Otro',
		'114'=>'Religión y espiritualidad',
		'107'=>'Salud y bienestar',
		'109'=>'Viajes y actividades al aire libre',
	];
	$formats = [
		"18"=>'Acampada, viaje o retiro',
		"17"=>'Atracción',
		"15"=>'Carrera o evento de resistencia',
		"8"=>'Cena o gala',
		"9"=>'Clase, curso o taller',
		"19"=>'Comparecencia o firma',
		"6"=>'Concierto o actuación',
		"1"=>'Conferencia',
		"4"=>'Convención',
		"10"=>'Encuentro o evento de red',
		"3"=>'Feria comercial, feria de consumo o exposición',
		"5"=>'Festival o feria',
		"11"=>'Fiesta o reunión social',
		"14"=>'Juego o competición',
		"100"=>'Otro',
		"7"=>'Proyección',
		"12"=>'Rally',
		"2"=>'Seminario o charla',
		"13"=>'Torneo',
		"16"=>'Visita',
	];
	//$events = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?token=4Y2ZJL5AREIS7R5BWABK');
	$events = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?token=Z5PUBQ6ROR7OYZM7YARV');
	$events = json_decode($events)->events;

	foreach($events as $key => $event){
		$node = Node::create(array(
		    'type' => 'eventos',
		    'title' => $event->name->text,
		    'langcode' => 'en',
		    'uid' => '1',
		    'status' => 1,
		    //'field_fields' => array(),
		));
		$node->save();
/*		$query = new EntityFieldQuery();
		$query->entityCondition('entity_type', 'node')
		->entityCondition('bundle', 'eventos')
		->fieldCondition('field_idevento', 'value', $event->id, '=');
		$result = $query->execute();
		if(count($result) == 0 ){
			$node = entity_create('node', array('type' => 'eventos'));
			$node->uid = 0;
		}else{
			$node = node_load(key($result['node']));
		}
		$node_wrapper = entity_metadata_wrapper('node', $node);
		$node_wrapper->title = $event->name->text;
		$node_wrapper->body  = array( 'value' => $event->description->html,'format' => 'full_html');
		$node_wrapper->field_idevento = $event->id;
		$node_wrapper->field_link = array(
			'url' =>  $event->url,
			'title' => ' Ingrase Aquí',
			'attributes'=>''
		);
		$date_start = str_replace('Z','',str_replace( 'T',' ',$event->start->utc ));
		$date_end = str_replace('Z','',str_replace( 'T',' ',$event->end->utc ));
		$node_wrapper->field_fecha = array(
			'value' => $date_start, 
			'value2' => $date_end,
			'timezone' => 'America/Bogota',
			'timezone_db' => 'UTC',
			'date_type' => 'datetime'
		);
		$node_wrapper->field_excepciones_ubicacion[] = 53;
		$node_wrapper->save();*/
	}
	}
}