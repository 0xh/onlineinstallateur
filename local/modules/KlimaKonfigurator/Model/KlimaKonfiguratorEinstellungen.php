<?php

namespace KlimaKonfigurator\Model;

use Thelia\Log\Tlog;

class KlimaKonfiguratorEinstellungen {
	
	private $raum_anzahl;
	private $raum_flaeche;
	private $raum_hoehe;
	private $fenster_anzahl;
	private $lage_der_zimmer;
	private $personen;
	private $anschlusswert_in_watt;
	
	private $hoehe_basis = 30;
	private $fenster_basis = 150;
	private $person_basis = 120;
	private $anschlusswert_anteil = 0.8;
	private $decke_lage_nk = 7, $decke_lage_db = 30, $decke_lage_i = 25;
	
	public function getRaumFlaeche() {
		return $this->raum_flaeche;
	}
	public function setRaumFlaeche($raum_flaeche) {
		$this->raum_flaeche = $raum_flaeche;
		return $this;
	}
	public function getRaumHoehe() {
		return $this->raum_hoehe;
	}
	public function setRaumHoehe($raum_hoehe) {
		$this->raum_hoehe = $raum_hoehe;
		return $this;
	}
	public function getFensterAnzahl() {
		return $this->fenster_anzahl;
	}
	public function setFensterAnzahl($fenster_anzahl) {
		$this->fenster_anzahl = $fenster_anzahl;
		return $this;
	}
	public function getLageDerZimmer() {
		return $this->lage_der_zimmer;
	}
	public function setLageDerZimmer($lage_der_zimmer) {
		$this->lage_der_zimmer = $lage_der_zimmer;
		return $this;
	}
	public function getPersonen() {
		return $this->personen;
	}
	public function setPersonen($personen) {
		$this->personen = $personen;
		return $this;
	}
	public function getAnschlusswertInWatt() {
		return $this->anschlusswert_in_watt;
	}
	public function setAnschlusswertInWatt($anschlusswert_in_watt) {
		$this->anschlusswert_in_watt = $anschlusswert_in_watt;
		return $this;
	}
	public function getRaumAnzahl() {
		return $this->raum_anzahl;
	}
	public function setRaumAnzahl($raum_anzahl) {
		$this->raum_anzahl = $raum_anzahl;
		return $this;
	}
	
	public function populateKonfiguratorFromRequest($request){
		$this->setRaumAnzahl($request->request->get('klimakonfigurator')['raumanzahl']);
		$this->setRaumFlaeche($request->request->get('klimakonfigurator')['grundflaeche']);
		$this->setRaumHoehe($request->request->get('klimakonfigurator')['raumhoehe']);
		$this->setFensterAnzahl($request->request->get('klimakonfigurator')['fenster']);
		$this->setLageDerZimmer($request->request->get('klimakonfigurator')['decke']);
		$this->setPersonen($request->request->get('klimakonfigurator')['personen']);
		$this->setAnschlusswertInWatt($request->request->get('klimakonfigurator')['zusaetzliche-waerme']);
	}
	
	public function calculateKlimaBedarf($room_id) {
		
		$lage_der_zimmer_bedarf = 0;
		switch($this->lage_der_zimmer[$room_id]){
			case 1:$lage_der_zimmer_bedarf = $this->decke_lage_nk;break;
			case 2:$lage_der_zimmer_bedarf = $this->decke_lage_db;break;
			case 3:$lage_der_zimmer_bedarf = $this->decke_lage_i;break;
		}
		$pro_meter2 = $this->raum_hoehe[$room_id]*$this->hoehe_basis + $lage_der_zimmer_bedarf;
		$klima_bedarf = $this->raum_flaeche[$room_id]*$pro_meter2+$this->fenster_anzahl[$room_id]*$this->fenster_basis+
		                $this->personen[$room_id]*$this->person_basis+$this->anschlusswert_in_watt[$room_id]*$this->anschlusswert_anteil;
		                
		return $klima_bedarf;
	}
	
	public function calculateKlimaBedarfMultipleRooms(){
	
		$gesamte_klima_bedarf = 0;
		
		for($i = 0; $i<$this->raum_anzahl; $i++){
			$gesamte_klima_bedarf += $this->calculateKlimaBedarf($i);
		}
		
		return $gesamte_klima_bedarf;
	}
	
	
}