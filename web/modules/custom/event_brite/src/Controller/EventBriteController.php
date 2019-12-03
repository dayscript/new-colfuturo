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
	//$events = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?token=Z5PUBQ6ROR7OYZM7YARV');
	$events = file_get_contents('https://www.eventbriteapi.com/v3/users/me/events/?token=JKZTJHNWOLTO65L7EIYC');
	$events = json_decode($events)->events;

	foreach($events as $key => $event){
		$query = \Drupal::entityQuery('node')
			->condition('type', 'eventos')
			->condition('field_idevento.value', $event->id, '=');
		$result = $query->execute();
		$getNid = key($result);
		//dpm($result);
		//dpm($result[$getNid]);
		switch ($event->organizer_id) {
		    case 28651177091:
		    	$organizador = 200;
		        break;
		    case 28651235497:
				$organizador = 201;
		        break;
		    case 28651271749:
				$organizador = 202;
		        break;
		}
		if(!$result){
			//dpm('Se crearon nodos');
			$node = \Drupal::entityTypeManager()->getStorage('node')->create([
				'type' => 'eventos',
			]);
		}else{
			//dpm('Se actualizaron nodos');
			$node = \Drupal::entityTypeManager()->getStorage('node')->load($result[$getNid]);
		}
			$node->title = $event->name->text;
			$node->body->value = $event->description->html;
			$node->body->format = 'full_html';
			$node->field_fecha->value = $event->start->local;
			$node->field_fecha->end_value = $event->end->local;
			$node->field_link = $event->url;
			$node->field_link->title = 'Regístrate';
			$node->field_link->options = [];
			$node->field_organizador->target_id = $organizador;
			$node->field_idevento = $event->id;
			$node->save();
			//break;
	}
	return [
      '#type' => 'markup',
      '#markup' => $this->t('Importacion completa'),
    ];
	}
}