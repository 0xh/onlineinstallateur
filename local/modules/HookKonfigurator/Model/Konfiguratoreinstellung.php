<?php
namespace  HookKonfigurator\Model;

/**
 * @author Emanuel Plopu
 *
 */
class Konfiguratoreinstellung
{
	private $brennstoff_momentan;
	private $brennstoff_zukunft;
	private $gebaeudeart;
	private $baujahr;
	private $lage_des_gebaeudes;
	private $windlage_des_gebaudes;
	private $lage_des_raumes;
	private $anzahl_aussenwaende;
	private $fenster;
	private $verglaste_flaeche;
	private $wohnraumtemperatur;
	private $aussentemperatur;
	private $waermedaemmung;
	private $flaeche;
	private $waermebedarf;
	
	
	public function getBrennstoffMomentan() {
		return $this->brennstoff_momentan;
	}
	public function setBrennstoffMomentan($brennstoff_momentan) {
		$this->brennstoff_momentan = $brennstoff_momentan;
		return $this;
	}
	public function getBrennstoffZukunft() {
		return $this->brennstoff_zukunft;
	}
	public function setBrennstoffZukunft($brennstoff_zukunft) {
		$this->brennstoff_zukunft = $brennstoff_zukunft;
		return $this;
	}
	public function getGebaeudeart() {
		return $this->gebaeudeart;
	}
	public function setGebaeudeart($gebaeudeart) {
		$this->gebaeudeart = $gebaeudeart;
		return $this;
	}
	public function getBaujahr() {
		return $this->baujahr;
	}
	public function setBaujahr($baujahr) {
		$this->baujahr = $baujahr;
		return $this;
	}
	public function getLageDesGebaeudes() {
		return $this->lage_des_gebaeudes;
	}
	public function setLageDesGebaeudes($lage_des_gebaeudes) {
		$this->lage_des_gebaeudes = $lage_des_gebaeudes;
		return $this;
	}
	public function getWindlageDesGebaudes() {
		return $this->windlage_des_gebaudes;
	}
	public function setWindlageDesGebaudes($windlage_des_gebaudes) {
		$this->windlage_des_gebaudes = $windlage_des_gebaudes;
		return $this;
	}
	public function getLageDesRaumes() {
		return $this->lage_des_raumes;
	}
	public function setLageDesRaumes($lage_des_raumes) {
		$this->lage_des_raumes = $lage_des_raumes;
		return $this;
	}
	public function getAnzahlAussenwaende() {
		return $this->anzahl_aussenwaende;
	}
	public function setAnzahlAussenwaende($anzahl_aussenwaende) {
		$this->anzahl_aussenwaende = $anzahl_aussenwaende;
		return $this;
	}
	public function getFenster() {
		return $this->fenster;
	}
	public function setFenster($fenster) {
		$this->fenster = $fenster;
		return $this;
	}
	public function getVerglasteFlaeche() {
		return $this->verglaste_flaeche;
	}
	public function setVerglasteFlaeche($verglaste_flaeche) {
		$this->verglaste_flaeche = $verglaste_flaeche;
		return $this;
	}
	public function getWohnraumtemperatur() {
		return $this->wohnraumtemperatur;
	}
	public function setWohnraumtemperatur($wohnraumtemperatur) {
		$this->wohnraumtemperatur = $wohnraumtemperatur;
		return $this;
	}
	public function getAussentemperatur() {
		return $this->aussentemperatur;
	}
	public function setAussentemperatur($aussentemperatur) {
		$this->aussentemperatur = $aussentemperatur;
		return $this;
	}
	public function getWaermedaemmung() {
		return $this->waermedaemmung;
	}
	public function setWaermedaemmung($waermedaemmung) {
		$this->waermedaemmung = $waermedaemmung;
		return $this;
	}
	public function getFlaeche() {
		return $this->flaeche;
	}
	public function setFlaeche($flaeche) {
		$this->flaeche = $flaeche;
		return $this;
	}
	public function getWaermebedarf() {
		return $this->waermebedarf;
	}
	public function setWaermebedarf($waermebedarf) {
		$this->waermebedarf = $waermebedarf;
		return $this;
	}
	
	public function populateKonfiguratorFromRequest($request){
		$this->setBrennstoffMomentan($request->request->get('konfigurator')['brennstoff_momentan']);
		$this->setBrennstoffZukunft($request->request->get('konfigurator')['brennstoff_zukunft']);
		$this->setGebaeudeart($request->request->get('konfigurator')['gebaeudeart']);
		$this->setBaujahr($request->request->get('konfigurator')['baujahr']);
		$this->setLageDesGebaeudes($request->request->get('konfigurator')['lage_des_gebaeudes']);
		$this->setWindlageDesGebaudes($request->request->get('konfigurator')['windlage_des_gebaudes']);
		$this->setLageDesRaumes($request->request->get('konfigurator')['lage_des_raumes']);
		$this->setAnzahlAussenwaende($request->request->get('konfigurator')['anzahl_aussenwaende']);
		$this->setFenster($request->request->get('konfigurator')['fenster']);
		$this->setVerglasteFlaeche($request->request->get('konfigurator')['verglaste_flaeche']);
		$this->setWohnraumtemperatur($request->request->get('konfigurator')['wohnraumtemperatur']);
		$this->setAussentemperatur($request->request->get('konfigurator')['aussentemperatur']);
		$this->setWaermedaemmung($request->request->get('konfigurator')['waermedaemmung']);
		$this->setFlaeche($request->request->get('konfigurator')['flaeche']);
	}
	
	public function calculateWaermebedarf(){
		
		$faktor = 22;//Fensterfläche:klein + Lage des Räumes
		switch ($this->gebaeudeart){
			case 1:$faktor+=15;break;
			case 2:$faktor+=11;break;
            case 3:$faktor+=8;break;
			case 4:$faktor+=5;
		}
		switch ($this->baujahr){
			case 1:$faktor+=15;break;
			case 2:$faktor+=11;break;
			case 3:$faktor+=8;break;
            case 4:$faktor+=5;
		}
		switch ($this->lage_des_gebaeudes){
			case 1:$faktor+=15;break;
			case 2:$faktor+=11;break;
			case 3:$faktor+=8;
		}
		switch ($this->windlage_des_gebaudes){
			case 1:$faktor+=15;break;
			case 2:$faktor+=11;break;
			case 3:$faktor+=8;
		}
		switch ($this->lage_des_raumes){
			case 0:$faktor+=15;break;
			case 1:$faktor+=15;break;
			case 2:$faktor+=11;break;
			default :$faktor+=8;
		}
		switch ($this->anzahl_aussenwaende){
			case 1:$faktor+=8;break;
			case 2:$faktor+=11;break;
			case 3:$faktor+=15;
		}
		switch ($this->fenster){
			case 1:$faktor+=15;break;
			case 2:$faktor+=11;break;
			case 3:$faktor+=8;
		}
		/*switch ($this->verglaste_flaeche){
			case 1:$faktor+=15;break;
			case 2:$faktor+=11;break;
			case 3:$faktor+=8;
		}*/
		switch ($this->wohnraumtemperatur){
			case 1:$faktor+=8;break;
			case 2:$faktor+=11;break;
            case 3:$faktor+=15;break;
			case 4:$faktor+=19;
		}
		switch ($this->aussentemperatur){
			case 1:$faktor+=8;break;
			case 2:$faktor+=11;break;
            case 2:$faktor+=15;break;
			case 3:$faktor+=19;
		}
		switch ($this->waermedaemmung){
			case 1:$faktor*=1.3;break;
			case 2:$faktor*=1;break;
			case 3:$faktor*=0.7;
		}
	$this->waermebedarf = $this->flaeche*$faktor;
	return $this->waermebedarf;
	}
	
}